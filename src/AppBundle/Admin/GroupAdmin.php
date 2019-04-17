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