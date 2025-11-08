<?php
namespace Mos\Kernel\EventBus;

class InMemoryEventBus implements \Mos\Kernel\Contracts\EventBusInterface
{
    protected $listeners = [];

    public function publish(string $eventType, array $payload = [], array $meta = [])
    {
        $envelope = [
            'id' => \Str::uuid(),
            'event_type' => $eventType,
            'payload' => $payload,
            'meta' => $meta,
            'occurred_at' => now()->toIso8601String(),
        ];

        if(isset($this->listeners[$eventType])){
            foreach($this->listeners[$eventType] as $listener){
                call_user_func($listener, $envelope);
            }
        }
    }

    public function subscribe(string $eventType, callable $handler)
    {
        $this->listeners[$eventType][] = $handler;
    }
}