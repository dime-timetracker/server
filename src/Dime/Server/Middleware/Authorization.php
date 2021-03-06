<?php

namespace Dime\Server\Middleware;

use Dime\Server\Session;
use Dime\Server\Responder\ResponderInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Authorization is a middleware and read the HTTP header Authorization or X-Authorization.
 *
 * Tasks:
 * - MUST check realm configuration
 * - MUST check the username, client, token exists in storage
 * - MUST check the updated_at with the configured expire period
 * - MUST delete token when expired
 *
 * Header:
 * Authorization: REALM USER,CLIENT,TOKEN
 *
 * or
 *
 * X-Authorization: REALM USER,CLIENT,TOKEN
 *
 * @author Danilo Kuehn <dk@nogo-software.de>
 */
class Authorization
{

    private $session;
    private $realm;
    private $expires;
    private $access;
    private $responder;

    /**
     * Constructor.
     *
     * @param array $access needs an array with [username => [[client => '', token => '', expires => 'parsable date'], ...]]
     * @param string $realm name of domain (default: 'Dime Timetracker')
     * @param string $expires parsable period (default: '1 week')
     */
    public function __construct(Session $session, ResponderInterface $responder, array $access, $realm = 'DimeTimetracker', $expires = '1 week')
    {
        $this->session = $session;
        $this->responder = $responder;
        $this->access = $access;
        $this->realm = $realm;
        $this->expires = $expires;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $authorization = $this->readAuthorizationHeader($request);

        if ($this->hasWrongRealm($authorization[0])) {
            return $this->fail($response);
        }

        if (!$this->hasAccess($authorization[1], $authorization[2], $authorization[3])) {
            return $this->fail($response);
        }
        
        return $next($request, $response);
    }

    protected function fail(ResponseInterface $response)
    {
        return $this->responder->respond($response, ['error' => 'Authentication error'], 401);
    }

    protected function readAuthorizationHeader(ServerRequestInterface $request)
    {
        $authorization = false;
        $headers = $request->getHeaders();
        if (!isset($headers['Authorization']) && function_exists('apache_request_headers')) {
            $all = apache_request_headers();
            if (isset($all['Authorization'])) {
                $authorization = $all['Authorization'];
            }
        } else {
            $authorization = $headers['X-Authorization'];
        }

        return (!empty($authorization)) ? preg_split('/[\s,]/', $authorization) : false;
    }

    protected function hasWrongRealm($realm)
    {
        return empty($realm) || $realm !== $this->realm;
    }

    protected function hasAccess($username, $client, $token)
    {
        if (!isset($this->access[$username])) {
            return false;
        }

        $user = $this->access[$username];
        $authorized = false;
        foreach ($user as $item) {
            if ($item['client'] === $client && $item['token'] === $token) {
                $this->session->setUserId($item['user_id']);
                $authorized = $this->expired($item['expires']);
                break;
            }
        }

        return $authorized;
    }

    protected function expired($date)
    {
        return strtotime('-' . $this->expires) <= strtotime($date);
    }

    protected function getUserId($username)
    {
        if (!isset($this->access[$username])) {
            return false;
        }

        return $this->access[$username]['id'];
    }

}
