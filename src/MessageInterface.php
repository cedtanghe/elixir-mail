<?php

namespace Elixir\Mail;

/**
 * @author Cédric Tanghe <ced.tanghe@gmail.com>
 */
interface MessageInterface
{
    /**
     * @param string $subject
     *
     * @return self
     */
    public function setSubject($subject);

    /**
     * @return string
     */
    public function getSubject();

    /**
     * @param string $body
     *
     * @return self
     */
    public function setBody($body);

    /**
     * @return string
     */
    public function getBody();

    /**
     * @param string $body
     *
     * @return self
     */
    public function setAlternate($body);

    /**
     * @return string
     */
    public function getAlternate();

    /**
     * @param string|array $addresses
     * @param string       $name
     *
     * @return self
     */
    public function setFrom($addresses, $name = null);

    /**
     * @return array
     */
    public function getFrom();

    /**
     * @param string|array $addresses
     * @param string       $name
     *
     * @return self
     */
    public function setTo($addresses, $name = null);

    /**
     * @return array
     */
    public function getTo();

    /**
     * @param mixed $entity
     *
     * @return self
     */
    public function attach($entity);

    /**
     * @param mixed $entity
     *
     * @return string
     */
    public function embed($entity);
}
