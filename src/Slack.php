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
	protected $channel;
	protected $emoji;
	protected $username;
	
	//public function __construct()
	//{
	//}
	
	public static function __callStatic($name, $arguments)
	{
		return call_user_func([static::makeClient(), $name], ...$arguments);
	}
	
	public static function makeClient(): SlackClient
	{
		return new SlackClient();
	}
	
	//public function channel($channel, $directMessage = false)
	//{
	//	$this->channel = ($directMessage ? '@' : '#') . $channel;
	//	return $this;
	//}
	//
	//public function emoji($emoji)
	//{
	//	$this->emoji = ':' . trim($emoji, ':') . ':';
	//	return $this;
	//}
	//
	//public function user($username)
	//{
	//	$this->username = $username;
	//	return $this;
	//}
	//
	//public function post($message)
	//{
	//	if (!$message)
	//		return $this;
	//
	//	$url = config('logging.channels.slack.url');
	//	if (!$url)
	//		return $this;
	//
	//	$payload = array_filter([
	//		'channel'    => $this->channel ?: config('logging.channels.slack.channel'),
	//		'text'       => $message,
	//		'icon_emoji' => $this->emoji,
	//		'username'   => $this->username,
	//	]);
	//
	//	Http::withBody('payload=' . json_encode($payload), 'application/x-www-form-urlencoded')
	//		->post($url);//post($url, compact('payload'));
	//
	//	return $this;
	//}
}