# Currency conversion tool

## Install
`composer install`

## Run
### Load
#### Updates the system with conversion rates.
`php src/App/Command/load.php`

### Convert
- Converts a currency and an amount into its USD equivalent.
Multiple conversion tuples can be passed as separate parameters.

`php src/App/Command/convert.php "<currency code> <amount>"`

Ex: `php src/App/Command/convert.php "JPy 2" "jpy 5" "jpy 9"`

## Assumptions
- Currency code use the standard representation. https://en.wikipedia.org/wiki/ISO_4217
- Conversion rates are only for USD.
- Provided input currency and value will be converted into USD if the rate is in the system.
- The XML providing conversion rates has no duplications. In the case of a duplicated rate for a currency, the last one in the list will be used.
- No historic data is needed for rates stored in the database.

## Notes
- The application uses `SimpleXMLElement` to fetch the XML data for simplicity.
An http client should be used and max items per request and/or pagination should be set for handling big sets of data in production environments.

## Todos
- Unit testing. Will ensure the application works as expected. Helps understand the business logic. Helps create more descriptive better organized code.
- Error handling. Will allow better control and error messages as feedback. 
- Input validation. Ex: Valid currency code.
- Use objects for handling data. Ex: Build a `Rate` entity and use it for saving and listing operations. 
- Create help messages for the command-line tasks.
- Abstract the logic for database access, loading and converting. Will provide flexibility to the solution.
This should take into account the size of the application or the expected changes. Abstraction add complexity.
- Format the code following wikimedia standards.
- Create a local config for sensitive data like the database password.