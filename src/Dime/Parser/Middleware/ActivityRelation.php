<?php

namespace Dime\Parser\Middleware;

use Dime\Server\Middleware\Middleware;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class ActivityRelation implements Middleware
{
    protected $regex = '/([@:\/])(\w+)/';
    protected $matches = array();

    public function run(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        return $next($request, $response);
    }


    public function clean($input)
    {
        if (!empty($this->matches)) {
            foreach ($this->matches[0] as $token) {
                $input = trim(str_replace($token, '', $input));
            }
        }

        return $input;
    }

    public function run($input)
    {
        // customer - project - service - tags (@ / : #)
        if (preg_match_all('/([@:\/#])(\w+)/', $input, $this->matches)) {
            foreach ($this->matches[1] as $key => $token) {
                switch ($token) {
                    case '@':
                        $this->result['customer'] = $this->matches[2][$key];
                        break;
                    case ':':
                        $this->result['service'] = $this->matches[2][$key];
                        break;
                    case '/':
                        $this->result['project'] = $this->matches[2][$key];
                        break;
                    case '#':
                        if (!isset($this->result['tags'])) {
                            $this->result['tags'] = array();
                        }
                        $this->result['tags'][] = $this->matches[2][$key];
                        $this->result['tags'] = array_unique($this->result['tags']);
                        break;
                }
            }
        }

        return $this->result;
    }

}
