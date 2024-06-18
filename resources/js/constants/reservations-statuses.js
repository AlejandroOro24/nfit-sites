/**
 *  Reservation Status id
 *
 *  @var  integer
 */
const PENDIENTE = 1;

/**
 *  Reservation Status id
 *
 * @var  integer
 */
const CONFIRMADA = 2;

/**
 *  Reservation Status id
 *
 * @var  integer
 */
const CONSUMIDA = 3;

/**
 *  Reservation Status id
 *
 *  @var  integer
 */
const PERDIDA = 4;

const ReservationStatus = {
    PENDIENTE, CONFIRMADA, CONSUMIDA, PERDIDA
};

export default ReservationStatus;
