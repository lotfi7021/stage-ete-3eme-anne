<?php

namespace Tests\Unit;

use App\Models\Admin;
use App\Models\CommandeM;
use App\Policies\CommandePolicy;
use PHPUnit\Framework\TestCase;

class CommandePolicyTest extends TestCase
{
    private CommandePolicy $policy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->policy = new CommandePolicy();
    }

    private function makeAdmin(string $role, int $id = 1): Admin
    {
        $admin = new Admin();
        $admin->forceFill(['id' => $id, 'role' => $role]);
        return $admin;
    }

    private function makeCommande(int $idClient = 10, int $idLivreur = 20): CommandeM
    {
        $commande = new CommandeM();
        $commande->forceFill(['id_client' => $idClient, 'id_livreur' => $idLivreur]);
        return $commande;
    }

    public function test_view_admin_toujours_autorise(): void
    {
        $this->assertTrue($this->policy->view($this->makeAdmin('admin'), $this->makeCommande()));
    }

    public function test_view_client_uniquement_ses_commandes(): void
    {
        $commande = $this->makeCommande(idClient: 10);
        $this->assertTrue($this->policy->view($this->makeAdmin('client', 10), $commande));
        $this->assertFalse($this->policy->view($this->makeAdmin('client', 11), $commande));
    }

    public function test_view_livreur_uniquement_ses_commandes(): void
    {
        $commande = $this->makeCommande(idLivreur: 20);
        $this->assertTrue($this->policy->view($this->makeAdmin('livreur', 20), $commande));
        $this->assertFalse($this->policy->view($this->makeAdmin('livreur', 21), $commande));
    }

    public function test_view_role_inconnu_refuse(): void
    {
        $this->assertFalse($this->policy->view($this->makeAdmin('autre'), $this->makeCommande()));
    }

    public function test_mark_delivered_admin_ou_livreur_assigne(): void
    {
        $commande = $this->makeCommande(idLivreur: 20);
        $this->assertTrue($this->policy->markDelivered($this->makeAdmin('admin'), $commande));
        $this->assertTrue($this->policy->markDelivered($this->makeAdmin('livreur', 20), $commande));
        $this->assertFalse($this->policy->markDelivered($this->makeAdmin('livreur', 21), $commande));
        $this->assertFalse($this->policy->markDelivered($this->makeAdmin('client', 10), $commande));
    }

    public function test_delete_admin_uniquement(): void
    {
        $commande = $this->makeCommande();
        $this->assertTrue($this->policy->delete($this->makeAdmin('admin'), $commande));
        $this->assertFalse($this->policy->delete($this->makeAdmin('client', 10), $commande));
        $this->assertFalse($this->policy->delete($this->makeAdmin('livreur', 20), $commande));
    }

    public function test_assign_livreur_admin_uniquement(): void
    {
        $commande = $this->makeCommande();
        $this->assertTrue($this->policy->assignLivreur($this->makeAdmin('admin'), $commande));
        $this->assertFalse($this->policy->assignLivreur($this->makeAdmin('client', 10), $commande));
        $this->assertFalse($this->policy->assignLivreur($this->makeAdmin('livreur', 20), $commande));
    }
}
