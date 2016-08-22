<?php

namespace Elixir\Mail;

use Elixir\Dispatcher\DispatcherInterface;

/**
 * @author Cédric Tanghe <ced.tanghe@gmail.com>
 */
interface MailInterface extends DispatcherInterface
{
    /**
     * @param callable|MessageInterface $message
     *
     * @return int
     */
    public function send($message);
}
