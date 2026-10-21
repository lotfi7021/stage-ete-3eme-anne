<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\CommandeM;

class CommandePolicy
{
    /**
     * Consultation d'une commande (facture, aperçu, détail).
     */
    public function view(Admin $admin, CommandeM $commande): bool
    {
        return match ($admin->role) {
            'admin' => true,
            'client' => (int) $commande->id_client === (int) $admin->id,
            'livreur' => (int) $commande->id_livreur === (int) $admin->id,
            default => false,
        };
    }

    /**
     * Marquer une commande comme livrée (livreur assigné uniquement).
     */
    public function markDelivered(Admin $admin, CommandeM $commande): bool
    {
        return $admin->role === 'admin'
            || ($admin->role === 'livreur' && (int) $commande->id_livreur === (int) $admin->id);
    }

    /**
     * Suppression d'une commande (admin uniquement).
     */
    public function delete(Admin $admin, CommandeM $commande): bool
    {
        return $admin->role === 'admin';
    }

    /**
     * Affectation d'un livreur (admin uniquement).
     */
    public function assignLivreur(Admin $admin, CommandeM $commande): bool
    {
        return $admin->role === 'admin';
    }
}
