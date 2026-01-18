public function findByPriceDesc(): array
{
    return $this->createQueryBuilder('p')
        ->orderBy('p.price', 'DESC')
        ->getQuery()
        ->getResult();
}
