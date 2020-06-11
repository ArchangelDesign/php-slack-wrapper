# PHP Slack Wrapper
#### Simple PHP Slack wrapper for quick integration

### Usage:

#### Initialize
```php
$legacyApiKey = 'xoxp-123456789-1234567890';
$slack = new \RaffMartinez\Slack\Slack($legacyApiKey);
```
#### Get channel list

```php
$channelList = $slack->getChannelList();
```
#### Post message
```php
$slack->postMessage($channelList[0], \RaffMartinez\Slack\Message::simpleMessage('Hello', 'MyBot'));
$ts = $slack->getLastMessageTs();
```

#### Reply to message
```php
$slack->postMessage($channelList[0], \RaffMartinez\Slack\Message::responseMessage('Hello', 'MyBot', $ts));
```

#### Get user list
```php
$allUsers = $slack->getUserList();
```
