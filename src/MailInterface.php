<?php

namespace Elixir\Mail;

use Elixir\Mail\MessageInterface;

/**
 * @author Cédric Tanghe <ced.tanghe@gmail.com>
 */
interface MailInterface
{
    /**
     * @param callable|MessageInterface $message
     * @return integer
     */
    public function send($message);
}
