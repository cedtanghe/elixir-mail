<?php

namespace Elixir\Mail;

use Elixir\View\ViewInterface;
use Swift_Message;

/**
 * @author Cédric Tanghe <ced.tanghe@gmail.com>
 */
class Message implements MessageInterface
{
    /**
     * @param string $path
     * @param string $contentType
     *
     * @return Swift_Attachment
     */
    public static function attachment($path, $contentType = null)
    {
        return Swift_Attachment::fromPath($path, $contentType);
    }

    /**
     * @var Swift_Message
     */
    protected $message;

    /**
     * @var ViewInterface
     */
    protected $view;

    /**
     * @var string
     */
    protected $alternate;

    /**
     * @var string
     */
    protected $template;

    /**
     * @param Swift_Message $message
     */
    public function __construct(Swift_Message $message)
    {
        $this->message = $message;
    }

    /**
     * @return Swift_Message
     */
    public function getSwiftMessage()
    {
        return $this->message;
    }

    /**
     * @param ViewInterface $view
     */
    public function setView(ViewInterface $view)
    {
        $this->view = clone $view;
        $this->view->share('message', $this);
    }

    /**
     * @return ViewInterface
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * {@inheritdoc}
     */
    public function setSubject($subject)
    {
        $this->message->setSubject($subject);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubject()
    {
        return $this->message->getSubject();
    }

    /**
     * {@inheritdoc}
     */
    public function setBody($body)
    {
        $args = func_get_args();
        $contentType = isset($args[1]) ? $args[1] : 'text/html';
        $charset = isset($args[2]) ? $args[2] : 'utf-8';

        if (null === $body && null !== $this->template) {
            $body = $this->template;
            $this->template = null;
        }

        $this->message->setBody($body, $contentType, $charset);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBody()
    {
        return $this->message->getBody();
    }

    /**
     * {@inheritdoc}
     */
    public function setAlternate($body)
    {
        $args = func_get_args();
        $contentType = isset($args[1]) ? $args[1] : 'text/plain';
        $charset = isset($args[2]) ? $args[2] : 'utf-8';

        if (null === $body && null !== $this->template) {
            $body = $this->template;
            $this->template = null;
        }

        $this->alternate = $body;
        $this->message->addPart($this->alternate, $contentType, $charset);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAlternate()
    {
        return $this->alternate;
    }

    /**
     * @param string $template
     * @param array  $parameters
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    public function withTemplate($template, array $parameters = [])
    {
        $this->template = $this->render($template, $parameters);

        return $this;
    }

    /**
     * @param string $template
     * @param array  $parameters
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    public function render($template, array $parameters = [])
    {
        return $this->view->render($template, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function setFrom($addresses, $name = null)
    {
        $this->message->setFrom($addresses, $name);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFrom()
    {
        return $this->message->getFrom();
    }

    /**
     * {@inheritdoc}
     */
    public function setTo($addresses, $name = null)
    {
        $this->message->setTo($addresses, $name);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTo()
    {
        return $this->message->getTo();
    }

    /**
     * {@inheritdoc}
     */
    public function attach($entity)
    {
        if (is_file($entity)) {
            $entity = static::attachment($entity);
        }

        $this->message->attach($entity);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function embed($entity)
    {
        if (is_file($entity)) {
            $entity = static::attachment($entity);
        }

        return $this->message->embed($entity);
    }

    /**
     * @ignore
     */
    public function __call($method, $arguments)
    {
        $result = call_user_func_array([$this->message, $method], $arguments);

        if ($result instanceof Swift_Message) {
            return $this;
        }

        return $result;
    }

    /**
     * @ignore
     */
    public function __clone()
    {
        if (null !== $this->view) {
            $this->view = clone $this->view;
        }

        $this->message = clone $this->message;
    }
}
