<?php declare(strict_types=1);

namespace App\GraphQL\Mutations;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Database\Eloquent\Model;
final readonly class AskBotQuestion
{
    /** @param  array{}  $args */
    public function __invoke(null $_, array $args)
    {
        // TODO implement the resolver
        $message = new Message();
        $message->message = Gemini::geminiPro()->generateContent($args['content'])->text();
        return $message;
    }
    
}
class Message extends Model{
    protected $fillable = [
        'message',
    ];
}
