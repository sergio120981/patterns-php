<?php

class Subject implements SplSubject {
    public $state;
    private $observers;
    function __construct(){
        $this->observers = new SplObjectStorage();
    }
    public function attach(SplObserver $observer): void {
        echo "Attached! \n";
        $this->observers->attach($observer);
    }
    public function detach(SplObserver $observer): void {
        echo "Detached \n";
        $this->observers->detach($observer);
    }
    public function notify(): void {
        echo "Notified!!! \n";
        foreach($this->observers as $o){
            $o->update($this);
        }
    }
    public function changeState(): void {
        $this->state=rand(1, 100);
        echo "cambiando el estado ".$this->state."\n";
        $this->notify();
    }
}


class Observer1 implements SplObserver {
    private $name;
    function __construct(string $name){
        $this->name=$name;
    }
    function update(SplSubject $sbj):void{
        if($sbj->state < 50) echo "Reaccionando a state menor de ".$this->name." 50! \n";
    }
}

class Observer2 implements SplObserver {
    private $name;
    function __construct(string $name){
        $this->name=$name;
    }
    function update(SplSubject $sbj):void{
        if($sbj->state >= 50) echo "Reaccionando MAYOR de 50!!!! ".$this->name." \n";
    }
}

$s=new Subject();

$o1=new Observer1('o1');
$o2=new Observer2('o2');
$o3=new Observer1('o3');

echo "creados 3 observadores \n";
$s->attach($o1);
$s->attach($o2);
$s->attach($o3);

echo "Attachados 3 observadores \n";

$s->changeState();
$s->changeState();

$s->detach($o3);

$s->changeState();

?>