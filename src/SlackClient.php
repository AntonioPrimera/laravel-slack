<?php

namespace AntonioPrimera\Slack;

use AntonioPrimera\Slack\Exceptions\InvalidSlackConfigurationException;
use Illuminate\Support\Facades\Http;

class SlackClient
{
	protected $channel;
	protected $emoji;
	protected $username;
	protected $slackWebhookUrl;
	
	/**
	 * @throws InvalidSlackConfigurationException
	 */
	public function __construct()
	{
		$this->slackWebhookUrl = config('slack.webhookUrl');
		if (!$this->slackWebhookUrl)
			throw new InvalidSlackConfigurationException('No webhook url found in config slack.webhookUrl');
	}
	
	public function channel(string $channel, bool $directMessage = false): SlackClient
	{
		$this->channel = ($directMessage ? '@' : '#') . $channel;
		return $this;
	}
	
	public function emoji(string $emoji): SlackClient
	{
		$this->emoji = ':' . trim($emoji, ':') . ':';
		return $this;
	}
	
	public function from(string $username): SlackClient
	{
		$this->username = $username;
		return $this;
	}
	
	public function directMessage(string $user, string $message): SlackClient
	{
		return $this->channel($user, true)->post($message);
	}
	
	public function post(string $message): SlackClient
	{
		if (!$message)
			return $this;
		
		$payload = array_filter([
			'channel'    => $this->channel ?: config('logging.channels.slack.channel'),
			'text'       => $message,
			'icon_emoji' => $this->emoji,
			'username'   => $this->username,
		]);
		
		Http::withBody('payload=' . json_encode($payload), 'application/x-www-form-urlencoded')
			->post($this->slackWebhookUrl);
		
		return $this;
	}
}