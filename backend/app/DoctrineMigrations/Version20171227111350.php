<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171227111350 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE playlist (id INT AUTO_INCREMENT NOT NULL, id_user INT DEFAULT NULL, name VARCHAR(100) NOT NULL, private TINYINT(1) NOT NULL, creationDate DATETIME NOT NULL, numberLike INT NOT NULL, INDEX IDX_D782112D6B3CA4B (id_user), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE playlistitem (id INT AUTO_INCREMENT NOT NULL, idVideo VARCHAR(20) NOT NULL, videoName VARCHAR(255) NOT NULL, videoDuration VARCHAR(20) NOT NULL, idPlaylist INT DEFAULT NULL, INDEX IDX_41A5260484213B76 (idPlaylist), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE played (id INT AUTO_INCREMENT NOT NULL, id_user INT DEFAULT NULL, idVideo VARCHAR(20) NOT NULL, datePlayed DATETIME NOT NULL, INDEX IDX_6CCDCF346B3CA4B (id_user), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vidlis_users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_C43D058C92FC23A8 (username_canonical), UNIQUE INDEX UNIQ_C43D058CA0D96FBF (email_canonical), UNIQUE INDEX UNIQ_C43D058CC05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_playlist (user_id INT NOT NULL, playlist_id INT NOT NULL, INDEX IDX_370FF52DA76ED395 (user_id), INDEX IDX_370FF52D6BBD148 (playlist_id), PRIMARY KEY(user_id, playlist_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE playlist ADD CONSTRAINT FK_D782112D6B3CA4B FOREIGN KEY (id_user) REFERENCES vidlis_users (id)');
        $this->addSql('ALTER TABLE playlistitem ADD CONSTRAINT FK_41A5260484213B76 FOREIGN KEY (idPlaylist) REFERENCES playlist (id)');
        $this->addSql('ALTER TABLE played ADD CONSTRAINT FK_6CCDCF346B3CA4B FOREIGN KEY (id_user) REFERENCES vidlis_users (id)');
        $this->addSql('ALTER TABLE user_playlist ADD CONSTRAINT FK_370FF52DA76ED395 FOREIGN KEY (user_id) REFERENCES vidlis_users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_playlist ADD CONSTRAINT FK_370FF52D6BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE playlistitem DROP FOREIGN KEY FK_41A5260484213B76');
        $this->addSql('ALTER TABLE user_playlist DROP FOREIGN KEY FK_370FF52D6BBD148');
        $this->addSql('ALTER TABLE playlist DROP FOREIGN KEY FK_D782112D6B3CA4B');
        $this->addSql('ALTER TABLE played DROP FOREIGN KEY FK_6CCDCF346B3CA4B');
        $this->addSql('ALTER TABLE user_playlist DROP FOREIGN KEY FK_370FF52DA76ED395');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE playlist');
        $this->addSql('DROP TABLE playlistitem');
        $this->addSql('DROP TABLE played');
        $this->addSql('DROP TABLE vidlis_users');
        $this->addSql('DROP TABLE user_playlist');
    }
}
