<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

class noeud {
    public $fils = array();
    public $numero; // Contenu dans le noeud de l'arbre
}

class arbre {
    public $courant = null;
    public $tab_racine = array();
    public $nbNoeud;

    function ajouterNumero($numero) {
    	$numero = (string) $numero;
		
    	if ($numero == ""){
            $this->courant->complet = true;
		} else {
			$num = $numero[0];
			
			if (is_null($this->courant)) {
				if (!isset($this->tab_racine[$num])) {
					$this->tab_racine[$num] = new noeud();
					$this->tab_racine[$num]->numero = $num;
					$this->courant = $this->tab_racine[$num];
					$this->nbNoeud++;
				} else {
					$this->courant = $this->tab_racine[$num];
				}
			} else {
				if (!isset($this->courant->fils[$num])) {
					$this->courant->fils[$num] = new noeud();
					$this->courant->fils[$num]->numero = $num;
					$this->courant = $this->courant->fils[$num];
					$this->nbNoeud++;
				} else {
					$this->courant = $this->courant->fils[$num];
				}
			}
			
			if (strlen($numero) > 1){
	        	$numero = substr($numero, 1, (strlen($numero)-1));
	        	$this->ajouterNumero($numero);
	        } else {
	        	$numero = "";
	        	$this->courant = null;
			}
		}
    }
}

$a = new arbre();

fscanf(STDIN, "%d",
    $N
);
for ($i = 0; $i < $N; $i++)
{
    fscanf(STDIN, "%s",
        $telephone
    );
    $a->ajouterNumero($telephone);
}

// Write an action using echo(). DON'T FORGET THE TRAILING \n
// To debug (equivalent to var_dump): error_log(var_export($var, true));


// The number of elements (referencing a number) stored in the structure.
echo($a->nbNoeud."\n");
?>