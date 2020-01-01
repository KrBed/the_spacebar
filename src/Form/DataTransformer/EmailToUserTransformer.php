<?php


namespace App\Form\DataTransformer;


use App\Entity\User;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class EmailToUserTransformer implements DataTransformerInterface
{

    /**
     * @inheritDoc
     */
    public function transform($value)
    {
      if(null === $value){
          return '';
      }

      if(!$value instanceof User){
          throw new \LogicException("The UserSelectType can only be a User class");
      }
      return $value->getEmail();
    }

    /**
     * @inheritDoc
     */
    public function reverseTransform($value)
    {
        dd('reverse transform', $value);
    }
}