namespace daliaIT\co3\package;
use daliaIT\co3\Inject;
class Package extends Inject
{
    protected 
        $name,
        $author,     
        $license.
        $src,
        $resource;
    
    public function geNamet(){ return $this->name; }
    public function setName( $value ){ $this->name = $value; return $this;}
    
    public function getAuthor(){ return $this->author; }
    public function setAuthor( $value ){ $this->author = $value; return $this;}
    
    public function getLicense(){ return $this->license; }
    public function setLicense( $value ){ $this->license = $value; return $this;}
    
    public function getSrc(){ return $this->src; }
    public function setSrc( $value ){ $this->src = $value; return $this;}
    
    public function getResource(){ return $this->resource; }
    public function setResource( $value ){ $this->resource = $value; return $this;}
}