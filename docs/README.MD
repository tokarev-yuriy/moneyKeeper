# Ubiquitous Language

* Double-entry bookkeeping - [https://en.wikipedia.org/wiki/Double-entry_bookkeeping](https://en.wikipedia.org/wiki/Double-entry_bookkeeping)
* User - id, name and email of a registered person
* Account - real or virtual account in bank, cash and etc
* Account group - group of accounts
* Transaction - information about transaction, also includes 2 transaction entries (1 for debit and 1 for credit)
* Transaction Entry - debit or credit entry of transaction
* Transaction Type - spend, income or transfer
* Transaction Category - categories of income or spends
# Architecture 

This is an attempt to implement "some" DDD principles to personal accounting application.

## Subdomains

![Components diagram](diagrams/out/components.png)
 
### Accounting

Main subdomain of application. It allows users to get, add, update and delete transactions.

It implements the Double-entry bookkeeping method of accounting.

![Accounting subdomain](diagrams/out/accounting.png)

### Plans

Support subdomain with ability to manage spend's plans. It allows users to get, add, update and delete plans.


![Plans subdomain](diagrams/out/plans.png)

### Categorizator

This subdomain has a categorization service, it tries to predict a category by transaction's information.


![Categorizator subdomain](diagrams/out/categorizator.png)

### Integrations

This subdomain has infrastructure for differenet integrations.

![Integrations subdomain](diagrams/out/integrations.png)

### Reports

This subdomain has reports and dashboard services.


![Reports subdomain](diagrams/out/reports.png)
