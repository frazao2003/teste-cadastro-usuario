<?php

namespace App\Repository;

use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Usuario>
 */
class UsuarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Usuario::class);
    }
    
        /**
     * Persiste e salva um novo usuário no banco de dados.
     *
     * @param Usuario $usuario A entidade Usuario a ser salva.
     * @return void
     */
    public function cadastrarUsuario(Usuario $usuario)
    {
        $em = $this->getEntityManager();
        $em->persist($usuario); // Marca a entidade para ser inserida no banco de dados.
        $em->flush(); // Executa a operação de persistência no banco de dados.
    }

//    /**
//     * @return Usuario[] Returns an array of Usuario objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

    public function findOneByName($name): ?Usuario
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.nome = :nome')
            ->setParameter('nome', $name)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findOneByEmail($email): ?Usuario
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
