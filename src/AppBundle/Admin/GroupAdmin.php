<?php


namespace AppBundle\Admin;



use Doctrine\ORM\OptimisticLockException;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class GroupAdmin
 * @package AppBundle\Admin
 */
class GroupAdmin extends AbstractAdmin
{

    // We wel recreate getObject in par Defaut it will be show with id getObject find
    public function getObject($id)
    {
        $object = $this->getModelManager()->findOneBy($this->getClass(), [
            'uuid' => $id
        ]);
        $this->object = $object;
        return $object;
    }


    // We call new function for generating URL sonata
    public function getUrlsafeIdentifier($entity)
    {
        ///$this->getRoutes();
        return $this->getNormalizedIdentifier($entity);
    }

    // Here url make new paramters tu URL uuid
    public function getNormalizedIdentifier($entity)
    {
        // If id not exist it wille be create
        if(is_null($entity->getId()))
        {
            return parent::getNormalizedIdentifier($entity);
        }
        // If id exist wie show url with UUID paramter
        else{
            return $entity->getUuid();
        }
    }


    /**
     * MesDevisAdmin constructor.
     * @param $object
     * @throws OptimisticLockException
     */
    public function preValidate($object) {
        $currentUSerId = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $object->getUserId()->setEnabled(true);
        $object->getUserId()->setRoles(['ROLE_GROUP_SOCIETE']);
        $object->getUserId()->setParent($currentUSerId);
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        /** @var $query */
        $query = parent::createQuery($context);
        $alias = $query->getRootAliases()[0];
        $user_idparent = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        $query
            ->innerJoin($alias.'.user_id','user_id')
            ->innerJoin('user_id.parent','user_idparent')
            ->where('user_idparent = :user_idparent')
            ->setParameters([
                'user_idparent' => $user_idparent
            ]);

        return $query;
    }


    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('user_id.username', TextType::class)
            ->add('user_id.email', EmailType::class)
            ->add('user_id.plainPassword', PasswordType::class)
        ;
    }


    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('user_id.username')
            ;
    }
}