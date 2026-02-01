<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
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
            ->setPageTitle(Crud::PAGE_EDIT, 'Edit User')
            ->setSearchFields(['username', 'email']);
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
        yield EmailField::new('email');
        
        yield ChoiceField::new('userType')
            ->setChoices([
                'STAFF' => 'STAFF',
                'PATIENT' => 'PATIENT',
            ]);

        // Password field - only show on new/edit forms
        if (in_array($pageName, [Crud::PAGE_NEW, Crud::PAGE_EDIT])) {
            yield TextField::new('password')
                ->setFormType(PasswordType::class)
                ->setRequired($pageName === Crud::PAGE_NEW)
                ->setHelp($pageName === Crud::PAGE_EDIT 
                    ? 'Leave empty to keep current password' 
                    : 'Enter a secure password');
        }

        yield ArrayField::new('roles')
            ->setHelp('Available roles: ROLE_ADMIN, ROLE_USER, etc.');
        
        yield AssociationField::new('role')
            ->setRequired(false)
            ->setHelp('Only for STAFF users');
        
        yield AssociationField::new('patient')
            ->setRequired(false)
            ->setHelp('Only for PATIENT users');
        
        yield BooleanField::new('isActive', 'Active');
        yield DateTimeField::new('createdAt')->onlyOnDetail();
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        /** @var User $user */
        $user = $entityInstance;

        // Hash password if it's provided (for new users it should be required)
        if ($user->getPassword()) {
            $user->setPassword(
                $this->userPasswordHasher->hashPassword($user, $user->getPassword())
            );
        }

        // Ensure roles array is not empty
        if (empty($user->getRoles())) {
            $user->setRoles(['ROLE_USER']);
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

        // Only hash password if a new one was provided and it's different from the original
        if ($user->getPassword()) {
            // For update, we need to check if it's actually a new password
            // Since we can't compare plain text to hash, we check if it looks like a hash
            // or if it's different from the original (this is not perfect but works for most cases)
            $newPassword = $user->getPassword();
            
            // If the password doesn't look like a hash (doesn't start with $2y$ or similar),
            // or if it's a completely new password, hash it
            if (!preg_match('/^\$2[ayb]\$.{56}$/', $newPassword) || $newPassword !== $originalPassword) {
                $user->setPassword(
                    $this->userPasswordHasher->hashPassword($user, $newPassword)
                );
            }
        } elseif ($originalPassword) {
            // Keep original password if no new password provided
            $user->setPassword($originalPassword);
        }

        parent::updateEntity($entityManager, $user);
    }
}