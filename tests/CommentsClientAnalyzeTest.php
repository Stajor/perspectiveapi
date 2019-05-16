<?php namespace PerspectiveApi\Test;

use PerspectiveApi\CommentsClient;
use PerspectiveApi\CommentsResponse;
use PHPUnit\Framework\TestCase;

class CommentsClientAnalyzeTest extends TestCase {
    protected static $response;

    public static function setUpBeforeClass(): void {
        $commentsClient = new CommentsClient(getenv('PERSPECTIVE_API_TOKEN'));
        $commentsClient->comment(['text' => 'You are an idiot', 'type' => 'PLAIN_TEXT']);
        $commentsClient->languages(['en']);
        $commentsClient->context(['entries' => ['text' => 'off-topic', 'type' => 'PLAIN_TEXT']]);
        $commentsClient->requestedAttributes(['TOXICITY' => ['scoreType' => 'PROBABILITY', 'scoreThreshold' => 0]]);
        $commentsClient->spanAnnotations(true);
        $commentsClient->doNotStore(true);
        $commentsClient->clientToken('some token');
        $commentsClient->sessionId('ses1');

        self::$response = $commentsClient->analyze(['attributeScores', 'detectedLanguages', 'languages']);
    }

    public function testHasCommentsResponseInstance() {
        $this->assertInstanceOf(CommentsResponse::class, self::$response);
    }

    public function testAnalyzeResponse(): void {
        $this->assertIsArray(self::$response->attributeScores());
        $this->assertIsArray(self::$response->languages());
    }
}
