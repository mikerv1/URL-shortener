<?php

declare(strict_types=1);

namespace App\Data\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220507055844 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE url_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_info_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE public.url_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE public.user_info_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE public.url (id INT NOT NULL, creation_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, original_url VARCHAR(255) NOT NULL, hash VARCHAR(255) NOT NULL, expiration_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, utm_source VARCHAR(255) DEFAULT NULL, utm_medium VARCHAR(255) DEFAULT NULL, utm_campaing VARCHAR(255) DEFAULT NULL, utm_term VARCHAR(255) DEFAULT NULL, utm_content VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CB9CFD9DD1B862B8 ON public.url (hash)');
        $this->addSql('CREATE INDEX hash_idx ON public.url (hash)');
        $this->addSql('COMMENT ON COLUMN public.url.creation_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN public.url.expiration_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE public.user_info (id INT NOT NULL, url_id INT NOT NULL, receive_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, request_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, user_ip inet NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_85A448B981CFDAE7 ON public.user_info (url_id)');
        $this->addSql('COMMENT ON COLUMN public.user_info.receive_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN public.user_info.request_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE public.user_info ADD CONSTRAINT FK_85A448B981CFDAE7 FOREIGN KEY (url_id) REFERENCES public.url (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA schema');
        $this->addSql('ALTER TABLE public.user_info DROP CONSTRAINT FK_85A448B981CFDAE7');
        $this->addSql('DROP SEQUENCE public.url_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE public.user_info_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE url_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_info_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP TABLE public.url');
        $this->addSql('DROP TABLE public.user_info');
    }
}
