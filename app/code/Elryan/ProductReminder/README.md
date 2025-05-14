# Elryan_ProductReminder Module

This Magento 2 module provides a feature for reminding customers about specific products they are interested in. It includes backend configuration options and REST API endpoints to manage product reminders.

## Installation

To install the Elryan_ProductReminder module, follow these steps:

1. **Download the Module**  
   Clone or download the module files into your Magento 2 installation directory under app/code/Elryan/ProductReminder.

2. **Navigate to Magento Root Directory**  
   Make sure you are in the root directory of your Magento installation before running any Magento CLI commands:

3. **Enable the Module**  
   Run the following Magento CLI commands:
   ```bash
   php bin/magento module:enable Elryan_ProductReminder
   php bin/magento setup:upgrade
   php bin/magento cache:flush
   php bin/magento setup:di:compile
   php bin/magento setup:static-content:deploy -f
   ```

4. **Verify the Installation**  
   Confirm the module is active by running:
   ```bash
   php bin/magento module:status | grep Elryan_ProductReminder
   ```

5. **Configure the Module**  
   In the Magento Admin Panel, go to **Stores** -> **Configuration** -> **General** -> **Product Reminder**. You will find the following settings:
    - **Enable Module**: Enable or disable the module functionality.
    - **Reminder Email Template**: Choose the email template for reminder notifications.

## REST API Endpoints

The Elryan_ProductReminder module exposes the following REST API endpoints for managing customer product reminders:

### 1. Set Reminder
**Endpoint:** `POST /V1/product-reminder`  
**Description:** Set a reminder for a specific product.  
**Payload:**
```json
{
  "customer_id": 123,
  "product_id": 456,
  "reminder_date": "2024-12-25"
}
```
**Validation:**
- The `reminder_date` must be in the future.
- The customer and product must exist in the Magento database.

### 2. Get All Reminders for a Customer
**Endpoint:** `GET /V1/product-reminder/{customer_id}`  
**Description:** Retrieve all reminders for a specific customer.  
**Response Example:**
```json
[
  {
    "id": 1,
    "product_id": 456,
    "reminder_date": "2024-12-25",
    "status": "Pending"
  }
]
```

### 3. Delete a Reminder
**Endpoint:** `DELETE /V1/product-reminder/{id}`  
**Description:** Remove a specific reminder by its ID.

## Database Table

The module uses a custom table `product_reminder` to store reminder information. Ensure this table is properly created during the module setup.

## Additional Resources

- [Magento Module Development Guide](https://devdocs.magento.com/guides/v2.4/extension-dev-guide/bk-extension-dev-guide.html)
- [Magento Dependency Injection](https://devdocs.magento.com/guides/v2.4/extension-dev-guide/depend-inj.html)
- [Magento REST API Overview](https://devdocs.magento.com/guides/v2.4/rest/bk-rest.html)

## License
This module is open-source and distributed under the MIT License.

## Support
For support or contribution requests, please contact the module author or create a pull request in the repository.
