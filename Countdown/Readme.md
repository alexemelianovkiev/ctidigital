# Installation

In order to install extension run next commend:

```
composer install ctidigital/countdown
```

# Starting with countdown:

In order to enable countdown go to:

```
Admin -> Stores -> Configuration -> Catalog -> Catalog -> Product Countdown
```

1. Enable extension.
2. Fill cut off time. You see 7 week days, you need only days, when orders can be dispatched.
3. Choose products for which you want to enable orders dispatch. Go to 

```
Admin -> Catalog -> Product -> Choose product -> Set "Product countdown status" to "yes".
```

# Technical dept:

- Currently product attribute is specified on the website scope and configuration on the global scope, according to test task, 
that was provided. It can bring inconsistency, if website time zone will not match global time zone.

- Need to add GraphQL support;

- Need to cover code with JS tests;

# Overview of taken approach:

1. System configuration with 7 different week days were created. 
2. 2 services were created:

```
    \Ctidigital\Countdown\Api\CountdownMappingInterface
    \Ctidigital\Countdown\Api\CountdownResolverInterface
```
3. Ui component was created. In order to listen observables changes. 
4. Interval was set and interval every minute is recalculating time left. 
5. If time is later than today cut off time, we need to calculate time till tomorow cut off. 
6. If time for tomorrow cut off was not specified, we need to calculate time till day after tomorrow.
7. This approach was done with recursion: ```countdown.calculateTime```
8. For time calculation moment.js was used


