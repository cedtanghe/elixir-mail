<?php

namespace Elixir\Mail;

use Elixir\Dispatcher\DispatcherInterface;
use Elixir\Mail\MessageInterface;

/**
 * @author Cédric Tanghe <ced.tanghe@gmail.com>
 */
interface MailInterface extends DispatcherInterface
{
    /**
     * @param callable|MessageInterface $message
     * @return integer
     */
    public function send($message);
}
