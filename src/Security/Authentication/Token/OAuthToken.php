<?php

namespace Gigablah\Silex\OAuth\Security\Authentication\Token;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;
use OAuth\Common\Token\TokenInterface as AccessTokenInterface;

/**
 * Token for OAuth Authentication responses.
 *
 * @author Chris Heng <bigblah@gmail.com>
 */
class OAuthToken extends AbstractToken implements OAuthTokenInterface
{
    protected $service;
    protected $uid;
    protected $email;
    protected $accessToken;
    protected $rawUserInfo;
    protected $providerKey;

    /**
     * Constructor.
     *
     * @param string $providerKey
     * @param array  $roles
     */
    public function __construct($providerKey, array $roles = array())
    {
        if (empty($providerKey)) {
            throw new \InvalidArgumentException('$providerKey must not be empty.');
        }

        $this->providerKey = $providerKey;

        parent::__construct($roles);

        if ($roles) {
            $this->setAuthenticated(true);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getCredentials()
    {
        return $this->accessToken->getAccessToken();
    }

    /**
     * {@inheritdoc}
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * {@inheritdoc}
     */
    public function setService($service)
    {
        $this->service = $service;
    }

    /**
     * {@inheritdoc}
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * {@inheritdoc}
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getAccessToken()
    {
        return $this->accessToken;
    }

    public function setAccessToken(AccessTokenInterface $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function getRawUserInfo()
    {
        return $this->rawUserInfo;
    }

    public function setRawUserInfo(array $rawUserInfo)
    {
        $this->rawUserInfo = $rawUserInfo;
    }


    public function getProviderKey()
    {
        return $this->providerKey;
    }


    public function __serialize(): array
    {
        return [$this->service, $this->uid, $this->email, $this->accessToken, $this->rawUserInfo, $this->providerKey, parent::__serialize()];
    }

    public function __unserialize(array $data): void
    {
        [$this->service, $this->uid, $this->email, $this->accessToken, $this->rawUserInfo, $this->providerKey, $parentData] = $data;
        $parentData = \is_array($parentData) ? $parentData : unserialize($parentData);
        parent::__unserialize($parentData);
    }
}
