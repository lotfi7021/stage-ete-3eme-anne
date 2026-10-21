<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class RoleGateTest extends TestCase
{
    private function makeAdmin(?string $role): Admin
    {
        $admin = new Admin();
        if ($role !== null) {
            $admin->forceFill(['role' => $role]);
        }
        return $admin;
    }

    public function test_gate_role_accepte_le_role_attendu(): void
    {
        $this->assertTrue(Gate::forUser($this->makeAdmin('admin'))->allows('role', 'admin'));
        $this->assertTrue(Gate::forUser($this->makeAdmin('client'))->allows('role', 'client'));
        $this->assertTrue(Gate::forUser($this->makeAdmin('livreur'))->allows('role', 'livreur'));
    }

    public function test_gate_role_accepte_une_liste_de_roles(): void
    {
        $this->assertTrue(Gate::forUser($this->makeAdmin('livreur'))->allows('role', ['admin', 'livreur']));
        $this->assertFalse(Gate::forUser($this->makeAdmin('client'))->allows('role', ['admin', 'livreur']));
    }

    public function test_gate_role_refuse_un_role_different(): void
    {
        $this->assertFalse(Gate::forUser($this->makeAdmin('client'))->allows('role', 'admin'));
        $this->assertFalse(Gate::forUser($this->makeAdmin('admin'))->allows('role', 'livreur'));
    }

    public function test_gate_role_refuse_un_utilisateur_non_authentifie(): void
    {
        $this->assertFalse(Gate::forUser(null)->allows('role', 'admin'));
    }
}
