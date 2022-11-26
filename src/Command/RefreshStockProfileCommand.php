<?php

namespace App\Command;

use App\Entity\Stock;
use App\Http\financeApiClient;
use App\Http\FinanceApiClientInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\SerializerInterface;

class RefreshStockProfileCommand extends Command
{
    protected static $defaultName = 'app:refresh-stock-profile';

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;
    /**
     * @var SerializerInterface
     */
    private $serializer;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(EntityManagerInterface $entityManager,
                                FinanceApiClientInterface $financeApiClient,
                                SerializerInterface $serializer,
                                LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;

        $this->financeApiClient = $financeApiClient;

        $this->serializer = $serializer;

        $this->logger = $logger;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Retrieve a stock profile from Bitfinex API. Add the record in to DB.')
            ->addArgument('symbol', InputArgument::REQUIRED, 'Stock symbol');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {


            // 1 Ping Bitfinex API and get data
            $stockProfile = $this->financeApiClient->fetchStockProfile($input->getArgument('symbol'));

            // 2Handle non 200 status code responces
            if ($stockProfile->getStatusCode() !== 200) {

                $output->writeln($stockProfile->getContent());

                return Command::FAILURE;
            }

            /** @var Stock $stock */
            $stock = $this->serializer->deserialize($stockProfile->getContent(), Stock::class, 'json');

            $this->entityManager->persist($stock);

            $this->entityManager->flush();

            $output->writeln($stock->getSymbol() . ' has been saved.');

            return Command::SUCCESS;
        } catch (\Exception $exception) {
            $this->logger->warning(get_class($exception) . ' : ' . $exception->getMessage() . ' in ' . $exception->getFile() . ' on line ' . $exception->getLine() . 'etc...');
            return Command::FAILURE;
        }
    }
}
