<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use App\Entity\App\User;
use App\Services\UserService;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180409204724 extends AbstractMigration implements ContainerAwareInterface
{
    private $container;
    private $userService;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->userService = $container->get('app.user');
    }

    private function createSuperadmin()
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');

        // SuperAdmin
        $user           = new User();
        $plainPassword  = 'superadminpassword';
        $user->setPassword($plainPassword);
        $user->setEmail("prueba@gmail.com");
        $user->setRoles(['ROLE_PRUEBA']);
        $user->setPhone('615357123');
        $user->setUsername('lalalal');

        $user = $this->userService->encodePassword($user);

        $em->persist($user);

        $em->flush();
    }

    public function postUp(Schema $schema )
    {
        $this->createSuperadmin();
    }

    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA App');
        $this->addSql('CREATE SEQUENCE App.users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE App.invoice_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE App.users (id INT NOT NULL, username VARCHAR(25) NOT NULL, email VARCHAR(254) NOT NULL, phone VARCHAR(254) NOT NULL, password VARCHAR(255) NOT NULL, is_active BOOLEAN NOT NULL, roles TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_80DF74E3F85E0677 ON App.users (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_80DF74E3E7927C74 ON App.users (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_80DF74E3444F97DD ON App.users (phone)');
        $this->addSql('COMMENT ON COLUMN App.users.roles IS \'(DC2Type:array)\'');
        $this->addSql('CREATE TABLE App.invoice (id INT NOT NULL, description TEXT NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE App.users_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE App.invoice_id_seq CASCADE');
        $this->addSql('DROP TABLE App.users');
        $this->addSql('DROP TABLE App.invoice');
    }
}
