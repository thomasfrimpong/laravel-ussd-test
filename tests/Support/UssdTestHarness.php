<?php

namespace Vendor\LaravelUssd\Tests\Support;

use Illuminate\Support\Facades\Event;
use Vendor\LaravelUssd\Machine\Machine;

class UssdTestHarness
{
    public function __construct(protected Machine $machine)
    {
        Event::fake();
    }

    public function dial(string $sessionId, string $msisdn, array $inputs): array
    {
        $responses = [];

        foreach ($inputs as $input) {
            $responses[] = (string) $this->machine->handle([
                'sessionId' => $sessionId,
                'msisdn' => $msisdn,
                'serviceCode' => '*123#',
                'input' => $input,
            ]);
        }

        return $responses;
    }
}
