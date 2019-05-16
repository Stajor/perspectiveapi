<?php namespace PerspectiveApi;

use GuzzleHttp\Client;

class CommentsClient {
    const API_URL = 'https://commentanalyzer.googleapis.com/v1alpha1';

    protected $token;
    protected $comment;
    protected $languages;
    protected $context;
    protected $requestedAttributes;
    protected $spanAnnotations;
    protected $doNotStore;
    protected $clientToken;
    protected $sessionId;

    public function __construct(string $token) {
        $this->token = $token;
    }

    public function analyze(array $fields): CommentsResponse {
        return $this->request('analyze', []);
    }

    public function suggestScore() {
        //TODO
    }

    public function comment(array $comment): void {
        $this->comment = $comment;
    }

    public function languages(array $languages): void {
        $this->languages = $languages;
    }

    public function context(array $context): void {
        $this->context = $context;
    }

    public function requestedAttributes(array $requestedAttributes): void {
        $this->requestedAttributes = $requestedAttributes;
    }

    public function spanAnnotations(bool $spanAnnotations): void {
        $this->spanAnnotations = $spanAnnotations;
    }

    public function doNotStore(bool $doNotStore): void {
        $this->doNotStore = $doNotStore;
    }

    public function clientToken(string $clientToken) {
        $this->clientToken = $clientToken;
    }

    public function sessionId(string $sessionId) {
        $this->sessionId = $sessionId;
    }

    public function attributeScores() {
        //TODO
    }

    public function communityId() {
        //TODO
    }

    protected function request(string $method, array $data): CommentsResponse {
        $fields = 'attributeScores,detectedLanguages,languages';
        $client = new Client(['defaults' => [
            'headers'  => ['content-type' => 'application/json', 'Accept' => 'application/json'],
        ]]);
        $response = $client->post(self::API_URL."/comments:{$method}?key={$this->token}&fields=".$fields, [
            'json' => [
                'comment' => $this->comment,
                'languages' => $this->languages,
                'requestedAttributes' => $this->requestedAttributes,
                'context'   => $this->context,
                'spanAnnotations' => $this->spanAnnotations,
                'doNotStore'    => $this->doNotStore,
                'clientToken'   => $this->clientToken,
                'sessionId' => $this->sessionId
            ]]);

        $result = json_decode($response->getBody(), true);

        return new CommentsResponse($result);
    }
}
