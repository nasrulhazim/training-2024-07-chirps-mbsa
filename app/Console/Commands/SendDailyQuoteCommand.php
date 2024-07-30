<?php

namespace App\Console\Commands;

use App\Events\SendQuote;
use Illuminate\Console\Command;

class SendDailyQuoteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quote';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send randomly selected quote to all users.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $quote = collect(
            $this->quotes()
        )->random();

        event(new SendQuote($quote));

        $this->components->info($quote);
    }

    private function quotes(): array
    {
        return [
            "The only way to do great work is to love what you do. - Steve Jobs",
            "Life is what happens when you're busy making other plans. - John Lennon",
            "The purpose of our lives is to be happy. - Dalai Lama",
            "Get busy living or get busy dying. - Stephen King",
            "You only live once, but if you do it right, once is enough. - Mae West",
            "Many of life's failures are people who did not realize how close they were to success when they gave up. - Thomas A. Edison",
            "If you want to live a happy life, tie it to a goal, not to people or things. - Albert Einstein",
            "Never let the fear of striking out keep you from playing the game. - Babe Ruth",
            "Money and success don’t change people; they merely amplify what is already there. - Will Smith",
            "Your time is limited, so don’t waste it living someone else’s life. - Steve Jobs",
            "Not how long, but how well you have lived is the main thing. - Seneca",
            "If life were predictable it would cease to be life, and be without flavor. - Eleanor Roosevelt",
            "The whole secret of a successful life is to find out what is one’s destiny to do, and then do it. - Henry Ford",
            "In order to write about life first you must live it. - Ernest Hemingway",
            "The big lesson in life, baby, is never be scared of anyone or anything. - Frank Sinatra",
            "Sing like no one’s listening, love like you’ve never been hurt, dance like nobody’s watching, and live like it’s heaven on earth. - Unknown",
            "Curiosity about life in all of its aspects, I think, is still the secret of great creative people. - Leo Burnett",
            "Life is not a problem to be solved, but a reality to be experienced. - Soren Kierkegaard",
            "The unexamined life is not worth living. - Socrates",
            "Turn your wounds into wisdom. - Oprah Winfrey",
            "The way I see it, if you want the rainbow, you gotta put up with the rain. - Dolly Parton",
            "Do all the good you can, for all the people you can, in all the ways you can, as long as you can. - Hillary Clinton",
            "Don’t settle for what life gives you; make life better and build something. - Ashton Kutcher",
            "Everybody wants to be famous, but nobody wants to do the work. I live by that. You grind hard so you can play hard. At the end of the day, you put all the work in, and eventually it’ll pay off. It could be in a year, it could be in 30 years. Eventually, your hard work will pay off. - Kevin Hart",
            "Everything negative – pressure, challenges – is all an opportunity for me to rise. - Kobe Bryant",
            "I like criticism. It makes you strong. - LeBron James",
            "You never really learn much from hearing yourself speak. - George Clooney",
            "Life imposes things on you that you can’t control, but you still have the choice of how you’re going to live through this. - Celine Dion",
            "Life is never easy. There is work to be done and obligations to be met – obligations to truth, to justice, and to liberty. - John F. Kennedy",
            "Live for each second without hesitation. - Elton John",
            "Life is like riding a bicycle. To keep your balance, you must keep moving. - Albert Einstein",
            "Life is really simple, but men insist on making it complicated. - Confucius",
            "Life is a succession of lessons which must be lived to be understood. - Ralph Waldo Emerson",
            "My mama always said, life is like a box of chocolates. You never know what you're gonna get. - Forrest Gump",
            "Watch your thoughts; they become words. Watch your words; they become actions. Watch your actions; they become habits. Watch your habits; they become character. Watch your character; it becomes your destiny. - Lao-Tze",
            "When we do the best we can, we never know what miracle is wrought in our life or the life of another. - Helen Keller",
            "The healthiest response to life is joy. - Deepak Chopra",
            "Life is what we make it, always has been, always will be. - Grandma Moses",
            "The secret of happiness, you see, is not found in seeking more, but in developing the capacity to enjoy less. - Socrates",
            "The way to get started is to quit talking and begin doing. - Walt Disney",
            "Your work is going to fill a large part of your life, and the only way to be truly satisfied is to do what you believe is great work. And the only way to do great work is to love what you do. - Steve Jobs",
            "It is our choices that show what we truly are, far more than our abilities. - J.K. Rowling",
            "Your time is limited, so don’t waste it living someone else’s life. - Steve Jobs",
            "Live in the sunshine, swim the sea, drink the wild air. - Ralph Waldo Emerson",
            "Life is short, and it is up to you to make it sweet. - Sarah Louise Delany",
            "The longer I live, the more I realize that the most important thing is to be comfortable with who you are. - Bruce Jenner",
            "Life doesn’t require that we be the best, only that we try our best. - H. Jackson Brown Jr.",
            "The only limit to our realization of tomorrow is our doubts of today. - Franklin D. Roosevelt",
            "Do what you can, with what you have, where you are. - Theodore Roosevelt",
            "The best time to plant a tree was 20 years ago. The second best time is now. - Chinese Proverb",
            "Only a life lived for others is a life worthwhile. - Albert Einstein",
            "The best way to predict your future is to create it. - Abraham Lincoln",
            "You have within you right now, everything you need to deal with whatever the world can throw at you. - Brian Tracy",
            "Believe you can and you're halfway there. - Theodore Roosevelt",
            "Act as if what you do makes a difference. It does. - William James",
            "Success is not final, failure is not fatal: it is the courage to continue that counts. - Winston Churchill",
            "The only thing standing between you and your goal is the story you keep telling yourself as to why you can't achieve it. - Jordan Belfort",
            "Don’t watch the clock; do what it does. Keep going. - Sam Levenson",
            "The secret of getting ahead is getting started. - Mark Twain",
            "The best revenge is massive success. - Frank Sinatra",
            "Keep your face always toward the sunshine—and shadows will fall behind you. - Walt Whitman",
            "Opportunities don't happen. You create them. - Chris Grosser",
            "Don't be afraid to give up the good to go for the great. - John D. Rockefeller",
            "I find that the harder I work, the more luck I seem to have. - Thomas Jefferson",
            "Success is not how high you have climbed, but how you make a positive difference to the world. - Roy T. Bennett",
            "What lies behind us and what lies before us are tiny matters compared to what lies within us. - Ralph Waldo Emerson",
            "Do not go where the path may lead, go instead where there is no path and leave a trail. - Ralph Waldo Emerson",
            "You only live once, but if you do it right, once is enough. - Mae West",
            "The only way to do great work is to love what you do. - Steve Jobs",
            "The best way to predict your future is to create it. - Peter Drucker",
            "Do not follow where the path may lead. Go instead where there is no path and leave a trail. - Ralph Waldo Emerson",
            "If you cannot do great things, do small things in a great way. - Napoleon Hill",
            "If opportunity doesn't knock, build a door. - Milton Berle",
            "Success is not the key to happiness. Happiness is the key to success. If you love what you are doing, you will be successful. - Albert Schweitzer",
            "Your time is limited, so don’t waste it living someone else’s life. - Steve Jobs",
            "In the end, it's not the years in your life that count. It's the life in your years. - Abraham Lincoln",
            "You miss 100% of the shots you don’t take. - Wayne Gretzky",
            "Whether you think you can or you think you can’t, you’re right. - Henry Ford",
            "The most difficult thing is the decision to act, the rest is merely tenacity. - Amelia Earhart",
            "Do what you can with all you have, wherever you are. - Theodore Roosevelt",
            "The best way to predict the future is to create it. - Abraham Lincoln",
            "I have learned over the years that when one’s mind is made up, this diminishes fear. - Rosa Parks",
            "Start where you are. Use what you have. Do what you can. - Arthur Ashe",
            "Ever tried. Ever failed. No matter. Try Again. Fail again. Fail better. - Samuel Beckett",
            "The only impossible journey is the one you never begin. - Tony Robbins",
            "The purpose of our lives is to be happy. - Dalai Lama",
            "Life is what happens when you’re busy making other plans. - John Lennon",
            "Get busy living or get busy dying. - Stephen King",
            "You have within you right now, everything you need to deal with whatever the world can throw at you. - Brian Tracy",
            "Believe you can and you're halfway there. - Theodore Roosevelt",
            "Act as if what you do makes a difference. It does. - William James",
            "Success is not final, failure is not fatal: it is the courage to continue that counts. - Winston Churchill",
            "Success usually comes to those who are too busy to be looking for it. - Henry David Thoreau",
            "I never dreamed about success. I worked for it. - Estée Lauder",
            "Don’t be afraid to give up the good to go for the great. - John D. Rockefeller"
        ];
    }
}
