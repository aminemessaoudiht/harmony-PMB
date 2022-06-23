<?php



namespace App\Models\Pmb;





use Illuminate\Database\Eloquent\Model;



class Bulletin extends Model
{
    protected $table = 'bulletins';
    public function exemplaires()
    {
        return $this->hasMany(Exemplaire::class, 'expl_bulletin', 'bulletin_id');
    }

}



