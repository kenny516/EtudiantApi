<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241214031235 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE semestre_semestre_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE matiere_matiere_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE etudiant_etudiant_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE note_note_id_seq CASCADE');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE etudiant DROP CONSTRAINT etudiant_pkey');
        $this->addSql('ALTER TABLE etudiant ALTER prenom SET NOT NULL');
        $this->addSql('ALTER TABLE etudiant ALTER prenom TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE etudiant ALTER nom SET NOT NULL');
        $this->addSql('ALTER TABLE etudiant ALTER nom TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE etudiant ALTER date_naissance SET NOT NULL');
        $this->addSql('ALTER TABLE etudiant RENAME COLUMN etudiant_id TO id');
        $this->addSql('ALTER TABLE etudiant ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE matiere DROP CONSTRAINT matiere_semestre_id_fkey');
        $this->addSql('ALTER TABLE matiere DROP CONSTRAINT matiere_pkey');
        $this->addSql('ALTER TABLE matiere ALTER code_matiere SET NOT NULL');
        $this->addSql('ALTER TABLE matiere ALTER code_matiere TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE matiere ALTER intitule SET NOT NULL');
        $this->addSql('ALTER TABLE matiere ALTER intitule TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE matiere ALTER credits SET NOT NULL');
        $this->addSql('ALTER TABLE matiere ALTER coefficient SET NOT NULL');
        $this->addSql('ALTER TABLE matiere RENAME COLUMN matiere_id TO id');
        $this->addSql('ALTER TABLE matiere ADD CONSTRAINT FK_9014574A5577AFDB FOREIGN KEY (semestre_id) REFERENCES semestre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matiere ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE note DROP CONSTRAINT note_matiere_id_fkey');
        $this->addSql('ALTER TABLE note DROP CONSTRAINT note_etudiant_id_fkey');
        $this->addSql('ALTER TABLE note DROP CONSTRAINT note_pkey');
        $this->addSql('ALTER TABLE note ADD session DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE note ALTER note TYPE NUMERIC(10, 2)');
        $this->addSql('ALTER TABLE note ALTER note SET NOT NULL');
        $this->addSql('ALTER TABLE note RENAME COLUMN note_id TO id');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE note ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE semestre DROP CONSTRAINT semestre_pkey');
        $this->addSql('ALTER TABLE semestre ALTER libelle SET NOT NULL');
        $this->addSql('ALTER TABLE semestre ALTER libelle TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE semestre RENAME COLUMN semestre_id TO id');
        $this->addSql('ALTER TABLE semestre ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE semestre_semestre_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE matiere_matiere_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE etudiant_etudiant_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE note_note_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE note DROP CONSTRAINT FK_CFBDFA14F46CD258');
        $this->addSql('ALTER TABLE note DROP CONSTRAINT FK_CFBDFA14DDEAB1A3');
        $this->addSql('DROP INDEX note_pkey');
        $this->addSql('ALTER TABLE note DROP session');
        $this->addSql('ALTER TABLE note ALTER note TYPE NUMERIC(15, 2)');
        $this->addSql('ALTER TABLE note ALTER note DROP NOT NULL');
        $this->addSql('ALTER TABLE note RENAME COLUMN id TO note_id');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT note_matiere_id_fkey FOREIGN KEY (matiere_id) REFERENCES matiere (matiere_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT note_etudiant_id_fkey FOREIGN KEY (etudiant_id) REFERENCES etudiant (etudiant_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE note ADD PRIMARY KEY (note_id)');
        $this->addSql('DROP INDEX semestre_pkey');
        $this->addSql('ALTER TABLE semestre ALTER libelle DROP NOT NULL');
        $this->addSql('ALTER TABLE semestre ALTER libelle TYPE VARCHAR(50)');
        $this->addSql('ALTER TABLE semestre RENAME COLUMN id TO semestre_id');
        $this->addSql('ALTER TABLE semestre ADD PRIMARY KEY (semestre_id)');
        $this->addSql('ALTER TABLE matiere DROP CONSTRAINT FK_9014574A5577AFDB');
        $this->addSql('DROP INDEX matiere_pkey');
        $this->addSql('ALTER TABLE matiere ALTER code_matiere DROP NOT NULL');
        $this->addSql('ALTER TABLE matiere ALTER code_matiere TYPE VARCHAR(50)');
        $this->addSql('ALTER TABLE matiere ALTER intitule DROP NOT NULL');
        $this->addSql('ALTER TABLE matiere ALTER intitule TYPE VARCHAR(100)');
        $this->addSql('ALTER TABLE matiere ALTER credits DROP NOT NULL');
        $this->addSql('ALTER TABLE matiere ALTER coefficient DROP NOT NULL');
        $this->addSql('ALTER TABLE matiere RENAME COLUMN id TO matiere_id');
        $this->addSql('ALTER TABLE matiere ADD CONSTRAINT matiere_semestre_id_fkey FOREIGN KEY (semestre_id) REFERENCES semestre (semestre_id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE matiere ADD PRIMARY KEY (matiere_id)');
        $this->addSql('DROP INDEX etudiant_pkey');
        $this->addSql('ALTER TABLE etudiant ALTER prenom DROP NOT NULL');
        $this->addSql('ALTER TABLE etudiant ALTER prenom TYPE VARCHAR(50)');
        $this->addSql('ALTER TABLE etudiant ALTER nom DROP NOT NULL');
        $this->addSql('ALTER TABLE etudiant ALTER nom TYPE VARCHAR(50)');
        $this->addSql('ALTER TABLE etudiant ALTER date_naissance DROP NOT NULL');
        $this->addSql('ALTER TABLE etudiant RENAME COLUMN id TO etudiant_id');
        $this->addSql('ALTER TABLE etudiant ADD PRIMARY KEY (etudiant_id)');
    }
}
