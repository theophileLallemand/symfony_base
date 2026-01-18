#[Route('/products')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'product_index')]
    public function index(ProductRepository $repo): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $repo->findAllOrderByPriceDesc(),
        ]);
    }

    #[Route('/new', name: 'product_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $product = new Product();
        $this->denyAccessUnlessGranted('PRODUCT_MANAGE', $product);

        // gestion MultiStepForm ici (session)
        // sauvegarde finale $em->persist($product)

        return new Response('Formulaire multi-étapes');
    }
}
