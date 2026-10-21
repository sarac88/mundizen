<?php

namespace Database\Factories;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ad>
 */
class AdFactory extends Factory
{
    protected $model = Ad::class;

    private static array $titles = [
        'manuales' => [
            'Masaje relajante con aceites esenciales',
            'Masaje terapéutico para contracturas',
            'Masaje deportivo para recuperación muscular',
            'Masaje sueco profesional a domicilio',
            'Masaje descontracturante para espalda y cervicales',
            'Masaje californiano relajante profundo',
            'Masaje linfático drenante anticelulítico',
            'Masaje de tejido profundo para dolores crónicos',
            'Reflexología podal y masaje de pies',
            'Masaje prenatal para embarazadas',
        ],
        'energeticas' => [
            'Reiki y terapia energética holística',
            'Shiatsu japonés equilibrio energético',
            'Masaje ayurvédico Abhyanga tradicional',
            'Terapia de puntos gatillo y bioenergética',
            'Masaje tailandés tradicional',
            'Masaje con piedras volcánicas calientes',
            'Acupresión y medicina tradicional china',
            'Masaje craniosacral relajación profunda',
            'Terapia Tuina masaje chino medicinal',
            'Masaje hawaiano Lomi Lomi',
        ],
        'cursos' => [
            'Curso de masaje relajante para parejas',
            'Formación masaje deportivo nivel básico',
            'Taller de masaje infantil para bebés',
            'Curso online de reflexología podal',
            'Formación en masaje terapéutico avanzado',
            'Taller práctico masaje con aceites',
            'Curso certificado de masaje tailandés',
            'Formación en drenaje linfático manual',
        ],
        'productos' => [
            'Pack aceites esenciales para masaje premium',
            'Set camilla profesional plegable completo',
            'Aceite de argán y rosa mosqueta para masajes',
            'Rodillo de jade facial y corporal',
            'Velas de masaje aromaterapia natural',
            'Bolas de masaje de bambú y piedras',
        ],
    ];

    private static array $descriptions = [
        'manuales' => [
            "Soy terapeuta titulada con más de 8 años de experiencia en masajes terapéuticos y relajantes. Me especializo en el tratamiento de contracturas, tensión cervical y estrés acumulado.\n\nUtilizo aceites naturales de primera calidad y adapto cada sesión a las necesidades específicas de cada persona. Trabajo con técnicas de masaje sueco, californiano y tejido profundo.\n\nDisponible en mi centro en el centro de la ciudad, también puedo desplazarme a tu domicilio. Primera sesión con descuento del 20%.",
            "Fisioterapeuta colegiada especializada en masaje deportivo y terapéutico. Trabajo con deportistas amateur y profesionales para optimizar la recuperación muscular y prevenir lesiones.\n\nTécnicas utilizadas: masaje deportivo pre y post competición, cyriax, stretching activo y pasivo, y liberación miofascial.\n\nCentro ubicado en zona bien comunicada con parking gratuito. Sesiones individuales y bonos.",
            "Masajista profesional con formación en diversas escuelas europeas. Cada sesión es un viaje hacia la relajación total del cuerpo y la mente.\n\nMe adapto completamente a tus necesidades: desde un masaje suave y relajante hasta uno más intenso para trabajar contracturas profundas. Uso productos ecológicos y libres de parabenos.\n\nHorarios flexibles, incluyendo fines de semana y festivos.",
        ],
        'energeticas' => [
            "Terapeuta holística certificada en Reiki Usui nivel maestro y terapia energética. Ofrezco sesiones de equilibrio energético que combinan diferentes técnicas para restablecer el flujo natural de energía del cuerpo.\n\nCada sesión incluye diagnóstico energético inicial, trabajo con los 7 chakras principales y armonización del campo áurico. Ambiente tranquilo y reconfortante.\n\nTambién ofrezco sesiones online y talleres grupales mensuales.",
            "Practicante de Shiatsu con 10 años de experiencia y formación en Japón. El Shiatsu trabaja los meridianos de energía del cuerpo mediante presión con los pulgares, palmas y codos.\n\nIdeal para: estrés y ansiedad, insomnio, dolores musculares, problemas digestivos y desequilibrios emocionales. Las sesiones se realizan sobre una colchoneta en el suelo, con ropa cómoda.\n\nPrimer consulta gratuita de 20 minutos.",
        ],
        'cursos' => [
            "Aprende las técnicas básicas y avanzadas del masaje relajante en este curso práctico de fin de semana. Ideal para parejas, cuidadores y cualquier persona que quiera aprender a dar un buen masaje.\n\nContenido: anatomía básica, técnicas de effleurage y petrissage, trabajo en espalda, piernas y pies, uso de aceites y cremas. Incluye material didáctico y aceites de práctica.\n\nGrupos reducidos (máximo 8 personas) para garantizar atención personalizada.",
            "Formación completa y certificada en masaje deportivo. Aprenderás todo lo necesario para trabajar con deportistas: desde la teoría de la fisiología del ejercicio hasta las técnicas más avanzadas de recuperación.\n\nEl curso consta de 40 horas presenciales divididas en 5 fines de semana. Al finalizar obtendrás un certificado reconocido. Prácticas incluidas con deportistas reales.",
        ],
        'productos' => [
            "Pack completo de aceites esenciales 100% naturales y orgánicos para masaje profesional. Incluye: aceite base de almendra dulce, jojoba, y 5 aceites esenciales (lavanda, eucalipto, menta, romero y naranja dulce).\n\nTodos los productos son certificados ecológicos, sin parabenos ni siliconas. Envasados en vidrio ámbar para preservar sus propiedades. Incluye guía de mezclas y usos recomendados.",
            "Set completo de camilla profesional plegable de aluminio ligero (solo 12 kg). Incluye: camilla, funda acolchada extraíble y lavable, reposacabezas anatómico, bolsa de transporte y accesorios.\n\nPerfecta para terapeutas que trabajan a domicilio o en diferentes centros. Capacidad de carga hasta 200 kg. Altura regulable de 63 a 83 cm.",
        ],
    ];

    public function definition(): array
    {
        $category = $this->faker->randomElement(['manuales', 'energeticas', 'cursos', 'productos']);
        $titles = self::$titles[$category];
        $descriptions = self::$descriptions[$category] ?? self::$descriptions['manuales'];

        $modes = ['presencial', 'domicilio', 'online'];
        $cities = ['Madrid', 'Barcelona', 'Valencia', 'Sevilla', 'Bilbao', 'Málaga', 'Zaragoza', 'Murcia', 'Palma', 'Las Palmas'];
        $priceUnits = ['por_sesion', 'por_hora', 'por_paquete'];
        $certOptions = ['Titulado', 'Certificado', 'Colegiado', 'Formación continua', 'Experiencia +5 años', 'Atención a domicilio'];
        $days = ['L', 'M', 'X', 'J', 'V', 'S', 'D'];

        return [
            'user_id' => User::factory(),
            'category' => $category,
            'title' => $this->faker->randomElement($titles),
            'description' => $this->faker->randomElement($descriptions),
            'certifications' => $this->faker->randomElements($certOptions, $this->faker->numberBetween(1, 3)),
            'mode' => $this->faker->randomElement($modes),
            'city' => $this->faker->randomElement($cities),
            'address' => $this->faker->streetAddress(),
            'availability' => $this->faker->randomElements($days, $this->faker->numberBetween(3, 6)),
            'price_unit' => $category === 'cursos' ? 'por_curso' : $this->faker->randomElement($priceUnits),
            'price' => $this->faker->randomElement([30, 40, 45, 50, 55, 60, 65, 70, 80, 90, 100, 120, 150, 200]),
            'duration' => $this->faker->randomElement([30, 45, 60, 75, 90]),
            'status' => Ad::STATUS_PUBLISHED,
            'terms_accepted' => true,
        ];
    }

    public function draft(): static
    {
        return $this->state(['status' => Ad::STATUS_DRAFT]);
    }

    public function forCategory(string $category): static
    {
        $titles = self::$titles[$category] ?? self::$titles['manuales'];
        $descriptions = self::$descriptions[$category] ?? self::$descriptions['manuales'];

        return $this->state([
            'category' => $category,
            'title' => $this->faker->randomElement($titles),
            'description' => $this->faker->randomElement($descriptions),
        ]);
    }
}
