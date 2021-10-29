<?php
namespace AntonioPrimera\Slack\Tests\Unit;

use AntonioPrimera\Slack\Slack;
use AntonioPrimera\Slack\SlackClient;
use AntonioPrimera\Slack\Tests\TestCase;
use Illuminate\Support\Facades\Http;

class PostMessageTest extends TestCase
{
	protected function setUp(): void
	{
		parent::setUp();
		
		config(['slack.webhookUrl' => 'https://test-slack-url.com/skack-secret']);
		Http::fake([
			'*' => Http::response('OK', 200),
		]);
	}
	
	/** @test */
	public function the_slac_static_methods_should_return_a_new_slack_client_instance()
	{
		$this->assertInstanceOf(SlackClient::class, Slack::makeClient());
		$this->assertInstanceOf(SlackClient::class, Slack::channel('abc'));
		$this->assertInstanceOf(SlackClient::class, Slack::emoji('abc'));
		$this->assertInstanceOf(SlackClient::class, Slack::from('abc'));
		$this->assertInstanceOf(SlackClient::class, Slack::post('abc'));
		$this->assertInstanceOf(SlackClient::class, Slack::directMessage('abc', 'abc'));
	}
	
	/** @test */
	public function the_slack_message_has_a_fixed_structure()
	{
		Slack::channel('my-channel')->emoji('my-emoji')->from('me')->post('Hello');
		
		$this->assertSlackDataIs([
			'text' => 'Hello',
			'channel' => '#my-channel',
			'icon_emoji' => ':my-emoji:',
			'username' => 'me',
		], true);
	}
	
	/** @test */
	public function messages_can_be_sent_directly_to_a_user()
	{
		Slack::from('me')->emoji('my-emoji')->directMessage('jim', 'Hello');
		
		$this->assertSlackDataIs([
			'text' => 'Hello',
			'channel' => '@jim',
			'icon_emoji' => ':my-emoji:',
			'username' => 'me',
		], true);
	}
	
	/** @test */
	public function messages_can_be_sent_directly_to_a_user_by_giving_it_as_a_channel_name()
	{
		Slack::from('me')->emoji('my-emoji')->channel('james', true)->post('Hello');
		
		$this->assertSlackDataIs([
			'text' => 'Hello',
			'channel' => '@james',
			'icon_emoji' => ':my-emoji:',
			'username' => 'me',
		], true);
	}
	
	//--- Protected helpers -------------------------------------------------------------------------------------------
	
	protected function assertSlackDataIs(array $expectedData, $strict, $dumpBody = false)
	{
		Http::assertSent(function($response) use ($expectedData, $strict, $dumpBody) {
			if ($dumpBody)
				dump($response->body());
			
			$this->assertTrue(strpos($response->body(), 'payload=') === 0);
			
			$json = substr($response->body(), strlen('payload='));
			$data = json_decode($json, true);
			
			foreach ($expectedData as $key => $value) {
				$this->assertArrayHasKey($key, $data, 'Slack request is missing key: ', $key);
				$this->assertEquals($value, $data[$key], "Wrong value for Slack request key '{$key}'.");
			}
			
			if ($strict)
				$this->assertCount(
					count($expectedData),
					$data,
					"Slack request has additional keys: "
						. implode(', ', array_keys(array_diff_key($data, $expectedData)))
				);
			
			return true;
		});
	}
}