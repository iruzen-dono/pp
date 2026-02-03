<?php
// Archived copy of Adresse.php — moved during cleanup on 2026-02-02
class AdresseException extends Exception {}

class Adresse {
    private int $numero;
    private string $nomRue;
    private string $codePostal;
    private string $localite;

    public function __construct(int $numero, string $nomRue, string $codePostal, string $localite) {
        if ($numero <= 0) {
            throw new AdresseException("Le numéro doit être un entier strictement positif");
        }
        
        $this->numero = $numero;
        $this->nomRue = $nomRue;
        $this->codePostal = $codePostal;
        $this->localite = $localite;
    }

    public function getNumero(): int {
        return $this->numero;
    }

    public function setNumero(int $numero): void {
        if ($numero <= 0) {
            throw new AdresseException("Le numéro doit être un entier strictement positif");
        }
        $this->numero = $numero;
    }

    public function getNomRue(): string {
        return $this->nomRue;
    }

    public function setNomRue(string $nomRue): void {
        $this->nomRue = $nomRue;
    }

    public function getCodePostal(): string {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): void {
        $this->codePostal = $codePostal;
    }

    public function getLocalite(): string {
        return $this->localite;
    }

    public function setLocalite(string $localite): void {
        $this->localite = $localite;
    }

    public function __toString(): string {
        return "{$this->numero} / {$this->nomRue} / {$this->codePostal} / {$this->localite}";
    }

    public function estDansLocalite(string $localite): bool {
        return strtolower($this->localite) === strtolower($localite);
    }
}

// Example usage preserved in archive
try {
    $ad1 = new Adresse(103, "Rue Amoussime", "7637", "Casablanca");
    echo $ad1 -> __toString()."<br>";

    $villeCherchee = "Casablanca";
    if ($ad1->estDansLocalite($villeCherchee)) {
        echo "L'adresse est bien située à $villeCherchee.<br>";
    }

    echo "<br>";

    $ad2 = new Adresse(-5, "Rue de la Paix", "75000", "Paris");
} catch (AdresseException $e) {
    echo "ATTENTION : " . $e->getMessage() . "<br>";
} catch (Exception $e) {
    echo "Autre erreur : " . $e->getMessage() . "<br>";
} finally {
    echo "Fin du traitement des adresses.<br>";
}
?>
