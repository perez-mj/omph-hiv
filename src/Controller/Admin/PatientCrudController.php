<?php
// In your PatientCrudController.php

namespace App\Controller\Admin;

use App\Entity\Patient;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\Uid\Uuid;

class PatientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Patient::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Patient')
            ->setEntityLabelInPlural('Patients');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('patientCode')
                ->setLabel('Patient Code')
                ->formatValue(function ($value, $entity) {
                    // For display
                    return $value ? (string) $value : '';
                })
                ->setFormTypeOption('attr', ['readonly' => $pageName === Crud::PAGE_EDIT])
                ->hideOnForm(), // Hide from forms if you want to auto-generate it
            'firstName',
            'lastName',
            'sex',
            'birthDate',
            'contactNo',
            'address',
            DateTimeField::new('createdAt')->onlyOnDetail(),

        ];
    }

    public function createEntity(string $entityFqcn): Patient
    {
        $patient = new Patient();
        $patient->setPatientCode(Uuid::v4());
        $patient->setCreatedAt(new \DateTimeImmutable());
        
        return $patient;
    }
}