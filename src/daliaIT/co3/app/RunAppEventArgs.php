namespace daliaIT\co3\app;
use daliaIT\co3\Inject;
class RunAppEventArgs extends Inject
{
    protected
        $app;
        
    public function getApp(){
        return $this->app;
    }
}