<?php

namespace Archriss\ArcExForm\Domain\Finishers;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Form\Domain\Finishers\AbstractFinisher;
use TYPO3\CMS\Form\Domain\Finishers\FinisherInterface;
use TYPO3\CMS\Form\Domain\Model\FormDefinition;

/**
 * Class ReceiverModifierFinisher
 *
 * @package Archriss\ArcExForm\Domain\Finishers
 */
class ReceiverModifierFinisher extends AbstractFinisher
{

    /**
     * Check if EmailToReceiver is an existing finisher and alter it's recipient list
     */
    protected function executeInternal()
    {
        // Only process if we have a field containing the subject and at least 1 recipients
        if (
            array_key_exists('subject', $this->options) &&
            $this->options['subject'] !== '' &&
            array_key_exists('recipients', $this->options) &&
            count($this->options['recipients'])
        ) {
            // Search form definition and finishers and process only if EmailToReceiver finisher is set
            $formDefinition = $this->finisherContext->getFormRuntime()->getFormDefinition();
            if ($formDefinition instanceof FormDefinition)
            {
                /* @var $finisher FinisherInterface */
                foreach ($formDefinition->getFinishers() as &$finisher)
                {
                    if (
                        $finisher instanceof FinisherInterface && 
                        $finisher->isEnabled() &&
                        $finisher->getFinisherIdentifier() == 'EmailToReceiver'
                    ) {
                        $subjectValue = $this->parseOption('subject');
                        $recipientList = $this->parseOption('recipients');
                        // If we found the subject in recipient list we'll change the finisher properties
                        if (
                            array_key_exists($subjectValue, $recipientList) &&
                            $this->validEmail($recipientList[$subjectValue])
                        ) {
                            list($recipientName, $recipientEmail) = $this->getNameEmail($recipientList[$subjectValue], $this->options['defaultName']);
                            $finisher->setOption('recipients', [$recipientEmail => $recipientName]);
                        }
                    }
                }
            }
        }
    }

    /**
     * @param string $email
     * @return bool
     */
    protected function validEmail($email)
    {
        $emailPart = $email;
        if (strpos($email, ' ') !== false)
        {
            list (, $emailPart) = GeneralUtility::revExplode(' ', $email, 2);
        }
        return GeneralUtility::validEmail($emailPart);
    }

    /**
     * @param string $email
     * @param string $defaultName
     * @return array
     */
    protected function getNameEmail($email, $defaultName = '')
    {
        $namePart = $defaultName;
        $emailPart = $email;
        if (strpos($email, ' ') !== false)
        {
            list ($namePart, $emailPart) = GeneralUtility::revExplode(' ', $email, 2);
        }
        return [$namePart, $emailPart];
    }
}