<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Booking;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');
        
        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);

        $adminUser = new User();
        $adminUser->setFirstName('Antoine')
                    ->setLastName('Rapiteau')
                    ->setIntroduction($faker->sentence())
                    ->setDescription('<p>' . join('</p><p>', $faker->paragraphs(3)) . '</p>')
                    ->setPicture('http://placehold.it/100x100')
                    ->setEmail('antoine.rapiteau@laposte.net')
                    ->setHash($this->encoder->encodePassword($adminUser, 'password'))
                    ->addUserRole($adminRole);
        $manager->persist($adminUser);
        
        $users = [];

        for ($i = 1; $i <= 10; $i++){
            $user = new User();

            $firstName = $faker->firstName();
            $lastName = $faker->lastName();
            $email = $faker->email();
            $introduction = $faker->sentence();
            $description = '<p>' . join('</p><p>', $faker->paragraphs(3)) . '</p>';
            $hash = $this->encoder->encodePassword($user, 'password');

            $genders = ['male', 'female'];

            $gender = $faker->randomElement($genders);

            $picture = 'https://randomuser.me/api/portraits/' . ($gender == 'male' ? 'men/' : 'women/') . $faker->numberBetween(1, 99) . '.jpg';


            $user->setFirstName($firstName)
                ->setLastName($lastName)
                ->setEmail($email)
                ->setIntroduction($introduction)
                ->setDescription($description)
                ->setHash($hash)
                ->setPicture($picture);

            $users[] = $user;
            $manager->persist($user);

        }

        

        for ($i = 1; $i <= 30; $i++)
        {     
            $ad = new Ad();

            $title = $faker->sentence();
            $coverImage = $faker->imageUrl(1000,350);
            $introduction = $faker->paragraph(2);
            $content = '<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>';
            $user = $users[mt_rand(0, count($users) - 1)];

            $ad->setTitle($title)
                ->setCoverImage($coverImage)
                ->setIntroduction($introduction)
                ->setContent($content)
                ->setPrice(mt_rand(40, 200))
                ->setRooms(mt_rand(1, 5))
                ->setAuthor($user);
            
            for ($j = 1; $j <= mt_rand(2, 5); $j++) {
                $image = new Image();

                $image->setUrl($faker->imageUrl())
                        ->setCaption($faker->sentence())
                        ->setAd($ad);

                $manager->persist($image);
            }

            // Réservations

            for ($j = 1; $j <= mt_rand(0, 10); $j++) {
                $booking = new Booking();

                $createdAt = $faker->dateTimeBetween('-6 months');
                $startDate = $faker->dateTimeBetween('-3 months');
                $duration = mt_rand(3, 10);

                $endDate = (clone $startDate)->modify("+$duration days");
                $amount = $ad->getPrice() * $duration;

                $booker = $users[mt_rand(0, count($users) - 1)];

                $comment = $faker->paragraph();

                $booking->setBooker($booker)
                        ->setAd($ad)
                        ->setStartDate($startDate)
                        ->setEndDate($endDate)
                        ->setCreatedAt($createdAt)
                        ->setAmount($amount)
                        ->setComment($comment);

                $manager->persist($booking);
            }
            
            $manager->persist($ad);
        }

        $manager->flush();
    }
}
