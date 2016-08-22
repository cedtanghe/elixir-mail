<?php

namespace Elixir\Mail;

use Elixir\Dispatcher\Event;

/**
 * @author Cédric Tanghe <ced.tanghe@gmail.com>
 */
class MailEvent extends Event
{
    /**
     * @var string
     */
    const PREPARE_MESSAGE = 'prepare_message';

    /**
     * @var string
     */
    const SEND_EMAIL = 'send_email';

    /**
     * @var MessageInterface
     */
    protected $message;

    /**
     * {@inheritdoc}
     *
     * @param array $params
     */
    public function __construct($type, array $params = [])
    {
        parent::__construct($type);
        $params += ['message' => null];

        $this->message = $params['message'];
    }

    /**
     * @return MessageInterface
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param MessageInterface $value
     */
    public function setMessage($value)
    {
        $this->message = $value;
    }
}
