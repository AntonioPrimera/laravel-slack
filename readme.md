# AntonioPrimera - Laravel Slack Client

This package enables users to send messages directly to slack. It is a wrapper for the Slack API, 
providing fluent (Laravel like) method calls.

## Installation

**Step 1.** Install package via Composer:

`composer require antonioprimera/laravel-slack`

**Step 2.** Set up a Slack WebHook and copy the webhook url.

If you don't know how to do this, check out this article:
https://slack.com/help/articles/115005265063-Incoming-webhooks-for-Slack

**Step 3.** Create an environment variable with the webhook url in your .env file.

```dotenv
SLACK_WEBHOOK_URL="https://hooks.slack.com/services/.../.../..."
```

**Step 4.** That's it. You can start sending messages to Slack.

## Usage

You can use one of the static methods on the **AntonioPrimera\Slack\Slack** class, or you can
instantiate a **AntonioPrimera\Slack\SlackClient** yourself. I recommend the first option and
this will be exemplified below.

The most basic usage will send a simple message to the default channel, chosen when you
defined the Webhook url. For this, you can use the **post** method.

```php
use AntonioPrimera\Slack\Slack;

Slack::post('This is the most basic usage, and will post a message to Slack');
```

You can fluently add several options to your message, to determine where it is sent to, the
sender name, an emoji etc. The example below will post a message to the channel "#my-channel",
coming from the user "Antonio" and will set the message emoji ":happy-face:".

```php
use AntonioPrimera\Slack\Slack;

Slack::channel('my-channel')
    ->from('Antonio')
    ->emoji('happy-face')
    ->post('Hello Slack!');
```

You can also send a direct message to a user, by using one of the following 2 options:

```php
use AntonioPrimera\Slack\Slack;

Slack::channel('james', true)
    ->from('Antonio')
    ->post('Hello James!');

Slack::from('Antonio')
    ->directMessage('james', 'Hello James!');
```

## Future development

In future versions I plan to include the following:

- optionally define the default Slack channel in the .env file
- optionally define the default sender in the .env file
- optionally define the default emoji in the .env file
- send messages to multiple channels and/or users
- conditionally send messages to multiple channels and/or users