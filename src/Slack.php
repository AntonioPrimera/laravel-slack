<?php

namespace AntonioPrimera\Slack;

/**
 * @method static SlackClient channel(string $channel, bool $directMessage = false)
 * @method static SlackClient emoji(string $emoji)
 * @method static SlackClient post(string $message)
 * @method static SlackClient from(string $username)
 * @method static SlackClient directMessage(string $user, string $message)
 */
class Slack
{
	
	public static function __callStatic($name, $arguments)
	{
		return call_user_func([static::makeClient(), $name], ...$arguments);
	}
	
	/**
	 * This client factory creates silent clients by default, so no
	 * exception is thrown if no webhook url is defined in .env
	 *
	 * @throws Exceptions\InvalidSlackConfigurationException
	 */
	public static function makeClient($silent = true): SlackClient
	{
		return new SlackClient($silent);
	}
}