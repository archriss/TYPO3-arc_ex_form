# Archriss Extended From - Allow to select recipient following specific field value #

## This extension able user to choose specific recipient over subject field in Form ##

Used to alter EmailToReceiver finisher recipient

This finisher must be used before EmailToReceiver. A field like selectbox containing enquiry list should defined in form and be used as selector field for finisher in order to reroute email.

## How it work

- Add Receiver list modifier before EmailToReceiver
- Fill the required fields
- That's all

Email can be prefixed by name in Recipient email
```
recipient name recipientemail@domain.tld
```

YAML Finisher example
```
finishers:
  -
    options:
      subject: '{selectbox-1}'
      recipients:
        Subject-1: 'My Name contact@domain.tld'
        'Facturation problem': billing@domain.tld
        'Account problem': account@domain.tld
      defaultName: 'My default name for billing and account'
    identifier: ReceiverModifier
``` 