namespace daliaIT\co3\hydra;
use daliaIT\co3;

class Type extends Inject{
    protected $name;
    protected $isAtomic;
    protected $parentType;
    
    public function name(){ return $this->name; }
    public function isAtomic(){ return $this->isAtomic; }
    public function parentType(){ return $this->parentType; }
}