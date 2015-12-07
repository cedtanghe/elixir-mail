<?php

namespace Elixir\Mail;

/**
 * @author Cédric Tanghe <ced.tanghe@gmail.com>
 */
interface MailInterface
{
    /**
     * @param mixed $message
     * @return integer
     */
    public function send($message);
}
