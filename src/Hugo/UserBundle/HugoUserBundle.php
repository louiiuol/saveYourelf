<?php

namespace Hugo\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class HugoUserBundle extends Bundle
{
	public function getParent()
  	{
    	return 'FOSUserBundle';
  	}
}
