# Data Provider

We have two providers collect data from them in JSON files we need to read and make some filter operations on them to get the result
- DataProviderX data is stored in [DataProviderX.json]
- DataProviderY data is stored in [DataProviderY.json]
- DataProviderX schema is:
  ```
   {
    parentAmount:200,
    Currency:'USD',
    parentEmail:'parent1@parent.eu',
    statusCode:1,
    registerationDate: '2018-11-30',
    parentIdentification: 'd3d29d70-1d25-11e3-8591-034165a3a613'
   }
  ```
- We have three statuses for DataProviderX
  - authorised which will have statusCode 1
  - decline which will have statusCode 2
  - refunded which will have statusCode 3

- DataProviderY schema is:
  ```
   {
    balance:300,
    currency:'AED',
    email:'parent2@parent.eu',
    status:100,
    created_at: '22/12/2018',
    id: '4fc2-a8d1'
   }
  ```
- We have three statuses for DataProviderY
  - authorised which will have statusCode 100
  - decline which will have statusCode 200
  - refunded which will have statusCode 300

## Acceptance Criteria
Using PHP Laravel, implement this API endpoint /api/v1/users
- It should list all users who combine transactions from all the available providerDataProviderX and DataProviderY )
- it should be able to filter results by payment providers for example /api/v1/users?provider=DataProviderX it should return users from DataProviderX
- it should be able to filter result three statusCode (authorised, decline, refunded) for example /api/v1/users?statusCode=authorised it should return all users from all providers that have status code authorised
- it should be able to filer by amount range for example /api/v1/users?balanceMin=10&balanceMax=100 it should return results between 10 and 100 including 10 and 100
- it should be able to filer by currency
- it should be able to combine all these filters together The Evaluation
  
