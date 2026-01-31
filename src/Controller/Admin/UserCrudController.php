<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher,
        private AdminUrlGenerator $adminUrlGenerator
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('User')
            ->setEntityLabelInPlural('Users')
            ->setPageTitle(Crud::PAGE_NEW, 'Create new User')
            ->setPageTitle(Crud::PAGE_EDIT, 'Edit User');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();
        yield TextField::new('username');

        // Password field with conditional configuration
        if (in_array($pageName, [Crud::PAGE_NEW, Crud::PAGE_EDIT])) {
            yield TextField::new('password')
                ->setFormType(PasswordType::class)
                ->setRequired($pageName === Crud::PAGE_NEW)
                ->setHelp($pageName === Crud::PAGE_EDIT ? 'Leave empty to keep current password' : 'Enter a secure password');
        }

        yield ArrayField::new('roles')
            ->setHelp('Available roles: ROLE_ADMIN, ROLE_USER, etc.');
        yield TextField::new('userType');
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        /** @var User $user */
        $user = $entityInstance;

        // Only hash password if it's provided (not empty)
        if ($user->getPassword()) {
            $user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user,
                    $user->getPassword()
                )
            );
        }

        parent::persistEntity($entityManager, $user);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        /** @var User $user */
        $user = $entityInstance;

        // Get the original entity from database
        $originalData = $entityManager->getUnitOfWork()->getOriginalEntityData($user);
        $originalPassword = $originalData['password'] ?? null;

        // Only hash password if it's changed (new password provided)
        if ($user->getPassword() && $user->getPassword() !== $originalPassword) {
            $user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user,
                    $user->getPassword()
                )
            );
        } elseif (!$user->getPassword() && $originalPassword) {
            // Keep the original password if no new password is provided
            $user->setPassword($originalPassword);
        }

        parent::updateEntity($entityManager, $user);
    }
}