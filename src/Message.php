<?php

namespace Elixir\Mail;

use Elixir\View\ViewInterface;
use Swift_Message;

/**
 * @author Cédric Tanghe <ced.tanghe@gmail.com>
 */
class Message
{
    /**
     * @var Swift_Message 
     */
    protected $message;

    /**
     * @var ViewInterface 
     */
    protected $view;
    
    /**
     * @param Swift_Message $message
     */
    public function __construct(Swift_Message $message)
    {
        $this->message = $message;
    }
    
    /**
     * @param ViewInterface $view
     */
    public function setView(ViewInterface $view)
    {
        $this->view = clone $view;
        $this->view->share('message', $this->message);
    }
    
    /**
     * @return ViewInterface
     */
    public function getView()
    {
        return $this->view;
    }
    
    /**
     * @see ViewInterface::render()
     * @see Swift_Message::setBody()
     * @throws \RuntimeException
     */
    public function withTemplate($template, array $parameters = [], $contentType = null, $charset = null)
    {
        if (null === $this->view)
        {
            throw new \RuntimeException('View component is not defined.');
        }
        
        $this->message->setBody($this->view->render($template, $parameters), $contentType, $charset);
        return $this;
    }
    
    /**
     * @return Swift_Message
     */
    public function getSwiftMessage()
    {
        return $this->message;
    }

    /**
     * @ignore
     */
    public function __clone()
    {
        if (null !== $this->view)
        {
            $this->view = clone $this->view;
        }
        
        $this->message = clone $this->message;
    }
}
