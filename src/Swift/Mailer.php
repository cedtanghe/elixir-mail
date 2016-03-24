<?php

namespace Elixir\Mail\Swift;

use Elixir\Mail\MailInterface;
use Elixir\Mail\Swift\Message;
use Elixir\View\ViewInterface;
use Swift_Mailer;
use Swift_Message;

/**
 * @author Cédric Tanghe <ced.tanghe@gmail.com>
 */
class Mail implements MailInterface 
{
    /**
     * @var Swift_Mailer 
     */
    protected $swift;
    
    /**
     * @var ViewInterface 
     */
    protected $view;
    
    /**
     * @param Swift_Mailer $swift
     */
    public function __construct(Swift_Mailer $swift)
    {
        $this->swift = $swift;
    }
    
    /**
     * @param ViewInterface $view
     */
    public function setView(ViewInterface $view)
    {
        $this->view = $view;
    }
    
    /**
     * @return ViewInterface
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @return Swift_Mailer
     */
    public function getSwiftMailer()
    {
        return $this->swift;
    }

    /**
     * {@inheritdoc}
     */
    public function send($message)
    {
        if (is_callable($message))
        {
            $m = new Message(Swift_Message::newInstance());
            
            if (null !== $this->view)
            {
                $m->setView($this->view);
            }
            
            $message = call_user_func_array($message, [$m]);
        }
        
        if ($message instanceof Message)
        {
            $message = $message->getSwiftMessage();
        }
        
        return $this->swift->send($message);
    }
    
    /**
     * @ignore
     */
    public function __call($method, $arguments) 
    {
        return call_user_func_array([$this->swift, $method], $arguments);
    }
}
