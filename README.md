# PHP Dummy Server: Simulate APIs for Easy Testing
The PHP Dummy Server is a library that allows you to create a mock server environment for testing applications that rely on external APIs or services. It simplifies testing by enabling you to define various responses (success, failure) and isolate your application from external dependencies.

## Benefits:

Reliable Tests: Ensures tests fail only due to genuine bugs in your code, not external factors.
Flexible Responses: Simulate different API responses (success, errors) for various test scenarios.
Decoupled Development: Start development on your application even before the actual service is available.
Isolated Teams: Allows development teams to work independently even if the real service is unstable.
Simplified Debugging: Isolate issues during deployment and debugging by simulating specific services locally.
## Getting Started

  - Installation

Install the library using Composer:

```Bash
composer require alirezamires/php-dummy-server --dev
```
Verwende den Code mit Vorsicht.
 -  Configuration

Edit the `server.php` file:

Define the Data Directory: Set the PHP_DUMMY_SERVER_ROOT_DIR constant to specify the location for storing dummy server data (e.g., responses).
 - Run the Server

Start the server using the following command in your terminal:

```Bash
php -S localhost:8000 server.php
```
Verwende den Code mit Vorsicht.
Defining Responses

Create a folder named dummy-data in the root directory specified in step 2.
Inside the `dummy-data` folder, create JSON files to define response data for different scenarios.
Supported HTTP Methods:

GET: Retrieves the data from the corresponding JSON file.\
POST: Creates a new JSON file with a unique identifier based on the request data.\
PUT: Updates the existing JSON file with the request data.\
DELETE: Deletes the existing JSON file.\
Example: Defining a Response for a GET Request.

Create a file named `1.json` inside the `dummy-data/user` folder with the following content:

```JSON
{
  "name": "John Doe",
  "email": "john.doe@example.com"
}
```
Now, any GET request to http://localhost:8000/user/1 will return the data from the user.json file.

## Additional Notes:

 - The server ignores empty files.
 - For more advanced usage and configuration options, refer to the official documentation (if available).
## License:

This library is licensed under the MIT License.

## Contributing

We welcome contributions to improve this library. Feel free to submit pull requests or open issues on the GitHub repository (link to repository if available).
