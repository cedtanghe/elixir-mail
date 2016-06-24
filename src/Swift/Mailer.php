<?php

namespace Elixir\Mail\Swift;

use Elixir\Dispatcher\DispatcherTrait;
use Elixir\Mail\MailEvent;
use Elixir\Mail\MailInterface;
use Elixir\Mail\Swift\Message;
use Elixir\View\ViewInterface;
use Swift_Mailer;
use Swift_Message;

/**
 * @author Cédric Tanghe <ced.tanghe@gmail.com>
 */
class Mailer implements MailInterface 
{
    use DispatcherTrait;
    
    /**
     * @var Swift_Mailer 
     */
    protected $swift;
    
    /**
     * @var callable 
     */
    protected $messageFactory;
    
    /**
     * @var ViewInterface 
     */
    protected $view;
    
    /**
     * @param Swift_Mailer $swift
     */
    public function __construct(Swift_Mailer $swift, callable $messageFactory = null)
    {
        $this->swift = $swift;
        $this->messageFactory = $messageFactory;
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
            $m = new Message($this->messageFactory ? call_user_func($this->messageFactory) : Swift_Message::newInstance());
            
            if (null !== $this->view)
            {
                $m->setView($this->view);
            }
            
            $message = call_user_func_array($message, [$m]);
        }
        
        $e = new MailEvent(MailEvent::PREPARE_MESSAGE, ['message' => $message]);
        $this->dispatch($e);
        
        $message = $e->getMessage();
        
        if (!$message)
        {
            return false;
        }
        
        $this->dispatch(new MailEvent(MailEvent::SEND_EMAIL));
        return $this->swift->send($message->getSwiftMessage());
    }
    
    /**
     * @ignore
     */
    public function __call($method, $arguments) 
    {
        return call_user_func_array([$this->swift, $method], $arguments);
    }
}
