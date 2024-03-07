# PHP Dummy Server For Check Response
Dummy Server allows you to receive all request via HTTP or HTTPS, such as a REST or RPC service.

This is useful in the following scenarios:

 - testing
  - easily recreate all types of responses for HTTP dependencies such as REST or RPC services to test applications easily and affectively
  - isolate the system-under-test to ensure tests run reliably and only fail when there is a genuine bug. It is important only the system-under-test is tested and not its dependencies to avoid tests failing due to irrelevant external changes such as network failure or a 
   server being rebooted / redeployed.
  - easily set up mock responses independently for each test to ensure test data is encapsulated with each test. Avoid sharing data between tests that is difficult to manage and maintain and risks tests infecting each other
  - create test assertions that verify the requests the system-under-test has sent
 - de-coupling development
 - start working against a service API before the service is available. If an API or service is not yet fully developed Dummy Server can mock the API allowing any team who is using the service to start work without being delayed
 - isolate development teams during the initial development phases when the APIs / services may be extremely unstable and volatile. Using MockServer allows development work to continue even when an external service fails
 - isolate single service
during deployment and debugging it is helpful to run a single application or service or handle a sub-set of requests on on a local machine in debug mode. Using MockServer it is easy to selectively forward requests to a local process running in debug mode, all other request can be forwarded to the real services for example running in a QA or UAT environment
## Installtion
To start using PHP Dummy Server, you need to require the plugin via Composer.
```bash 
composer require alirezamires/php-dummy-server --dev
```
## Config
Open file named ``server.php``:
```php
namespace Alirezamires\DummyServer;
require_once __DIR__ . '/vendor/autoload.php';
define("PHP_DUMMY_SERVER_ROOT_DIR", __DIR__ . '/data');

Request::save();
Response::send();
```
Config root directory for dummy server's data:
```php
define("PHP_DUMMY_SERVER_ROOT_DIR", __DIR__ . '/data');
```
## Usage
Run this comment in terminal:

```bash 
php -S localhost:8000 server.php
```
### Index Route
In root directory make folder name ``dummy-data`` and then make json file named ``.json``:
```json
{
    "test":"test"
}
```
> [!WARNING]
> Server ignore empty files.
## License

[MIT](https://github.com/electron/electron/blob/main/LICENSE)
