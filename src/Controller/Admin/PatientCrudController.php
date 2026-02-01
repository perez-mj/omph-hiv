<?php

namespace App\Controller\Admin;

use App\Entity\Patient;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PatientCrudController extends AbstractCrudController
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher,
        private AdminUrlGenerator $adminUrlGenerator
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return Patient::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Patient')
            ->setEntityLabelInPlural('Patients')
            ->setPageTitle('index', 'Patients')
            ->setPageTitle('new', 'Create Patient')
            ->setPageTitle('edit', 'Edit Patient')
            ->setPageTitle('detail', 'Patient Details')
            ->setSearchFields(['firstName', 'lastName', 'patientCode', 'contactNo'])
            ->setDefaultSort(['createdAt' => 'DESC']);
    }

    public function configureActions(Actions $actions): Actions
    {
        // Create custom action for enrolling user account
        $enrollUserAction = Action::new('enrollUser', 'Enroll User Account', 'fa fa-user-plus')
            ->linkToCrudAction('enrollUser')
            ->displayIf(function (Patient $patient) {
                // Only show if patient doesn't have a user account
                return $patient->getUser() === null;
            });

        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_INDEX, $enrollUserAction)
            ->add(Crud::PAGE_DETAIL, $enrollUserAction)
            ->add(Crud::PAGE_EDIT, Action::INDEX)
            ->add(Crud::PAGE_NEW, Action::INDEX)
            ->setPermission('enrollUser', 'ROLE_ADMIN'); // Optional: restrict who can use this action
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            IdField::new('id')
                ->onlyOnIndex()
                ->setLabel('ID'),

            TextField::new('patientCode')
                ->setLabel('Patient Code')
                ->setFormTypeOption('disabled', true)
                ->hideWhenCreating(),

            TextField::new('firstName')
                ->setLabel('First Name')
                ->setRequired(true),

            TextField::new('lastName')
                ->setLabel('Last Name')
                ->setRequired(false),

            ChoiceField::new('sex')
                ->setLabel('Gender')
                ->setChoices([
                    'Male' => 'M',
                    'Female' => 'F',
                ])
                ->setRequired(true)
                ->renderExpanded(),

            DateField::new('birthDate')
                ->setLabel('Birth Date')
                ->setRequired(false)
                ->setFormat('yyyy-MM-dd'),

            TextField::new('contactNo')
                ->setLabel('Contact Number')
                ->setRequired(false)
                ->setHelp('Format: 09XXXXXXXXX or +639XXXXXXXXX'),

            TextField::new('address')
                ->setLabel('Address')
                ->setRequired(false)
                ->hideOnIndex(),
        ];

        // Add user association field with simpler formatting
        if ($pageName === Crud::PAGE_INDEX) {
            $fields[] = AssociationField::new('user')
                ->setLabel('User Account')
                ->formatValue(function ($value, $entity) {
                    $user = $entity->getUser();
                    if ($user) {
                        return $user->getUsername();
                    }
                    return 'No account';
                })
                ->setCssClass('text-center');
        } elseif ($pageName === Crud::PAGE_DETAIL) {
            $fields[] = AssociationField::new('user')
                ->setLabel('User Account')
                ->formatValue(function ($value, $entity) {
                    $user = $entity->getUser();
                    if ($user) {
                        return sprintf(
                            '<strong>Username:</strong> %s<br><strong>Email:</strong> %s<br><strong>Status:</strong> %s',
                            $user->getUsername(),
                            $user->getEmail() ?? 'N/A',
                            $user->isActive() ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>'
                        );
                    }
                    return '<span class="badge badge-warning">No user account</span>';
                })
                ->onlyOnDetail();
        }

        // Add computed/readonly fields for detail view
        if ($pageName === Crud::PAGE_DETAIL) {
            $fields[] = DateTimeField::new('createdAt')
                ->setLabel('Created At')
                ->setFormat('yyyy-MM-dd HH:mm:ss');

            $fields[] = NumberField::new('age')
                ->setLabel('Age')
                ->formatValue(function ($value, $entity) {
                    $age = $entity->getAge();
                    return $age !== null ? $age : 'N/A';
                })
                ->onlyOnDetail();

            $fields[] = TextField::new('fullName')
                ->setLabel('Full Name')
                ->formatValue(function ($value, $entity) {
                    return $entity->getFullName();
                })
                ->onlyOnDetail();
        } elseif ($pageName === Crud::PAGE_INDEX) {
            $fields[] = TextField::new('fullName')
                ->setLabel('Full Name')
                ->formatValue(function ($value, $entity) {
                    return $entity->getFullName();
                })
                ->onlyOnIndex();
        }

        return $fields;
    }

    /**
     * Custom action to enroll a user account for a patient
     */
    public function enrollUser(AdminContext $context, EntityManagerInterface $entityManager): RedirectResponse
    {
        // Method 1: Check if entity exists in context
        $entityDto = $context->getEntity();

        if (!$entityDto) {
            // Method 2: Try to get entity ID from request
            $patientId = $context->getRequest()->query->get('entityId');

            if (!$patientId) {
                $this->addFlash('error', 'Could not determine patient. Please try again.');

                return $this->redirect(
                    $this->adminUrlGenerator
                        ->setController(self::class)
                        ->setAction(Action::INDEX)
                        ->generateUrl()
                );
            }

            // Fetch patient by ID from database
            $patient = $entityManager->getRepository(Patient::class)->find($patientId);

            if (!$patient) {
                throw $this->createNotFoundException(sprintf('Patient with ID %s not found.', $patientId));
            }
        } else {
            /** @var Patient $patient */
            $patient = $entityDto->getInstance();
        }

        // Check if patient already has a user account
        if ($patient->getUser()) {
            $this->addFlash('warning', 'This patient already has a user account.');

            return $this->redirect(
                $this->adminUrlGenerator
                    ->setController(self::class)
                    ->setAction(Action::DETAIL)
                    ->setEntityId($patient->getId())
                    ->generateUrl()
            );
        }

        // Generate username (you can customize this logic)
        $username = $this->generateUsername($patient, $entityManager);

        // Generate initial password
        $initialPassword = bin2hex(random_bytes(8));

        // Create user account
        $user = new User();
        $user->setUsername($username);
        $user->setEmail($this->generateEmail($patient));
        $user->setUserType('PATIENT');
        $user->setRoles(['ROLE_USER', 'ROLE_PATIENT']);
        $user->setPatient($patient);
        $user->setIsActive(true);

        // Hash the password immediately - never store plaintext!
        $hashedPassword = $this->userPasswordHasher->hashPassword($user, $initialPassword);
        $user->setPassword($hashedPassword);

        // Persist the user
        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('success', sprintf(
            'User account created successfully!<br>Username: <strong>%s</strong><br>Initial Password: <strong>%s</strong>',
            $username,
            $initialPassword
        ));

        return $this->redirect(
            $this->adminUrlGenerator
                ->setController(self::class)
                ->setAction(Action::DETAIL)
                ->setEntityId($patient->getId())
                ->generateUrl()
        );
    }
    /**
     * Helper method to generate username
     */
    private function generateUsername(Patient $patient, EntityManagerInterface $entityManager): string
    {
        // Clean the base username
        $baseUsername = strtolower($patient->getFirstName()[0] . $patient->getLastName());
        $username = preg_replace('/[^a-z0-9]/', '', $baseUsername);

        // Check if username exists and add numbers if needed
        $userRepository = $entityManager->getRepository(User::class);

        $counter = 1;
        $originalUsername = $username;

        while ($userRepository->findOneBy(['username' => $username])) {
            $username = $originalUsername . $counter;
            $counter++;
        }

        return $username;
    }

    /**
     * Helper method to generate email
     */
    private function generateEmail(Patient $patient): string
    {
        // You can implement your own email generation logic
        // For now, create a placeholder
        $domain = 'example.com'; // Change this to your actual domain
        $baseEmail = strtolower($patient->getFirstName() . '.' . $patient->getLastName() . '@' . $domain);
        $email = preg_replace('/[^a-z0-9.@]/', '', $baseEmail);

        // Ensure email is unique or handle duplicates
        return $email;
    }

    public function createEntity(string $entityFqcn)
    {
        $patient = new Patient();

        // Generate patient code for new patients
        $patient->generatePatientCode();

        return $patient;
    }
}